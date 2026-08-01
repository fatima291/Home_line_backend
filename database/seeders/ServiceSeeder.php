<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'التنظيف المنزلي',
                'description' => 'تنظيف المنازل والمكاتب والفلل باستخدام معدات احترافية.',
                'image' => 'imegs/T2.jfif',
            ],
            [
                'name' => 'تنظيف المكيفات',
                'description' => 'تنظيف مكيفات السبليت لتحسين كفاءة التبريد وجودة الهواء وإطالة عمر المكيف.',
                'image' => 'imegs/T7.jfif',
            ],
            [
                'name' => 'خدمة مناسبات',
                'description' => 'توفير عاملات ومباشرات محترفات لخدمة الضيافة وتنظيم المناسبات بكل احترافية.',
                'image' => 'imegs/T3.jfif',
            ],
            [
                'name' => 'مكافحة الحشرات',
                'description' => 'القضاء على الحشرات المنزلية باستخدام مواد آمنة وفعالة مع الحفاظ على نظافة المكان.',
                'image' => 'imegs/T4.jfif',
            ],
            [
                'name' => 'أعمال كهرباء',
                'description' => 'تركيب وصيانة وإصلاح الأعطال الكهربائية بأيدي فنيين متخصصين.',
                'image' => 'imegs/T6.jfif',
            ],
            [
                'name' => 'أعمال السباكة',
                'description' => 'إصلاح وتركيب وصيانة وتمديد شبكات المياه بكفاءة.',
                'image' => 'imegs/T5.jfif',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}