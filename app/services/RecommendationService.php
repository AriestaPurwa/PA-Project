<?php

namespace App\Services;

class RecommendationService
{
    public static function get($projectType, $riskLevel)
    {
        $rules = [

            'Software Development' => [
                'Low' => 'Lakukan monitoring rutin dan dokumentasikan perubahan.',
                'Medium' => 'Tingkatkan pengujian dan lakukan code review secara berkala.',
                'High' => 'Prioritaskan backup data, pengujian, dan monitoring keamanan sistem.',
            ],

            'Construction' => [
                'Low' => 'Lakukan pemantauan rutin terhadap aktivitas proyek.',
                'Medium' => 'Lakukan inspeksi dan evaluasi progres secara berkala.',
                'High' => 'Tingkatkan pengawasan lapangan dan penerapan SOP keselamatan.',
            ],

            'Research' => [
                'Low' => 'Dokumentasikan perkembangan penelitian secara rutin.',
                'Medium' => 'Evaluasi jadwal dan kebutuhan sumber daya penelitian.',
                'High' => 'Siapkan rencana kontinjensi dan validasi hasil penelitian.',
            ],

            // fallback
            'General Project' => [
                'Low' => 'Lakukan pemantauan rutin dan dokumentasikan perubahan.',
                'Medium' => 'Siapkan rencana mitigasi dan lakukan pengendalian berkala.',
                'High' => 'Prioritaskan tindakan mitigasi dan lakukan monitoring intensif.',
            ],
        ];

        return $rules[$projectType][$riskLevel]
            ?? 'Belum tersedia rekomendasi.';
    }
}