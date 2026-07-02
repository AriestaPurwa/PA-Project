<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risk;

class RiskSeeder extends Seeder
{
    public function run(): void
    {
        $risks = [
            [
                'project_id' => 1,
                'category_id' => 2,
                'nama_risiko' => 'Server Down',
                'probability' => 5,
                'impact' => 5,
                'deskripsi' => 'Server tidak dapat diakses'
            ],
            [
                'project_id' => 1,
                'category_id' => 2,
                'nama_risiko' => 'Database Corrupt',
                'probability' => 4,
                'impact' => 5,
                'deskripsi' => 'Data rusak'
            ],
            [
                'project_id' => 1,
                'category_id' => 3,
                'nama_risiko' => 'Bug pada sistem',
                'probability' => 3,
                'impact' => 3,
                'deskripsi' => 'Kesalahan logika program'
            ],
            [
                'project_id' => 1,
                'category_id' => 3,
                'nama_risiko' => 'Integrasi gagal',
                'probability' => 2,
                'impact' => 4,
                'deskripsi' => 'API tidak terhubung'
            ],
            [
                'project_id' => 1,
                'category_id' => 2,
                'nama_risiko' => 'Overload Server',
                'probability' => 4,
                'impact' => 4,
                'deskripsi' => 'Server tidak mampu menangani traffic'
            ],
        ];

        foreach ($risks as $r) {

            $score = $r['probability'] * $r['impact'];

            // Tentukan level
            if ($score >= 15) {
                $level = 'High';
            } elseif ($score >= 8) {
                $level = 'Medium';
            } else {
                $level = 'Low';
            }

            Risk::create([
                'project_id' => $r['project_id'],
                'category_id' => $r['category_id'],
                'nama_risiko' => $r['nama_risiko'],
                'probability' => $r['probability'],
                'impact' => $r['impact'],
                'risk_score' => $score,
                'risk_level' => $level,
                'deskripsi' => $r['deskripsi'],
            ]);
        }
    }
}