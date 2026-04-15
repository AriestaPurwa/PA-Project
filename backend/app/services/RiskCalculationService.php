<?php

namespace App\Services;

use App\Models\RiskCategory;

class RiskCalculationService
{
    /**
     * Hitung score category secara recursive
     */
    public function calculateCategoryScore(RiskCategory $category)
    {
        $scores = [];

        // 1️⃣ Ambil risk langsung di category ini
        foreach ($category->risks as $risk) {
            $scores[] = $risk->probability * $risk->impact;
        }

        // 2️⃣ Ambil child categories (recursive)
        foreach ($category->children as $child) {
            $childScore = $this->calculateCategoryScore($child);

            if ($childScore !== null) {
                $scores[] = $childScore;
            }
        }

        if (empty($scores)) {
            return null;
        }

        // 3️⃣ Terapkan aggregation rule
        return $this->applyRule($scores, $category->aggregation_method);
    }

    /**
     * Rule Engine
     */
    private function applyRule(array $scores, string $method)
    {
        switch ($method) {

            case 'average':
                return array_sum($scores) / count($scores);

            case 'sum':
                return array_sum($scores);

            case 'max':
            default:
                return max($scores);
        }
    }

    // public function classifyRiskLevel($score)
    // {
    //     if ($score <= 5) {
    //         return 'low';
    //     }

    //     if ($score <= 10) {
    //         return 'medium';
    //     }

    //     if ($score <= 15) {
    //         return 'high';
    //     }

    //     return 'extreme';
    // }

    public function calculateRiskScore($risk)
    {
        return $risk->probability * $risk->impact;
    }

    public function attachScoresRecursively($category)
    {
        $totalScore = 0;
        $riskCount = 0;

        // =====================
        // Hitung risk langsung
        // =====================
        if ($category->risks) {
            foreach ($category->risks as $risk) {

                if (!is_null($risk->probability) && !is_null($risk->impact)) {
                    $score = $risk->probability * $risk->impact;

                    $risk->calculated_score = $score;

                    $totalScore += $score;
                    $riskCount++;
                }
            }
        }

        // =====================
        // Hitung children
        // =====================
        if ($category->children) {
            foreach ($category->children as $child) {

                $this->attachScoresRecursively($child);

                $totalScore += $child->calculated_score ?? 0;
                $riskCount++;
            }
        }

        // =====================
        // Average Score
        // =====================
        $category->calculated_score =
            $riskCount > 0 ? round($totalScore / $riskCount, 2) : 0;

        // =====================
        // Risk Level
        // =====================
        $category->risk_level =
            $this->classifyRiskLevel($category->calculated_score);
    }

    /**
     * Risk Level Classification
     */
    public function classifyRiskLevel($score)
    {
        if ($score >= 15) return 'High';
        if ($score >= 8) return 'Medium';
        if ($score > 0) return 'Low';

        return 'None';
    }

    public function generateRiskMatrix($projectId)
    {
        $matrix = [];

        // buat grid kosong 5x5
        for ($impact = 1; $impact <= 5; $impact++) {
            for ($probability = 1; $probability <= 5; $probability++) {
                $matrix[$impact][$probability] = 0;
            }
        }

        // ambil semua risk project
        $risks = \App\Models\Risk::where('project_id', $projectId)->get();

        foreach ($risks as $risk) {

            if (!is_null($risk->probability) && !is_null($risk->impact)) {
                $matrix[$risk->impact][$risk->probability]++;
            }
        }
            
        return $matrix;
    }


    public function getHeatmapColor($impact, $probability)
    {
        $score = $impact * $probability;

        // if ($score >= 15) return 'extreme';
        // if ($score >= 10) return 'high';
        // if ($score >= 5) return 'medium';
        if ($score >= 15) return 'High';
        if ($score >= 8) return 'Medium';
        if ($score > 0) return 'Low';

        return 'none';
    }
}