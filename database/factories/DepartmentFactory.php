<?php
$departments = [
    'مجلـس االدارة',
    'الـمـديــر التنفيــذي',
    'سكرتارية المدير التنفيذي',
    'ادارة العلاقات العامة',
    'الادارة المالية',
    'ادارة شئون العاملين',
    'الادارة القانونية',
    'ادارة شئون العضوية',
    'ادارة المشتريات',
    'اداره المخازن',
    'ادارة النشاط الرياضي',
    'الادارة الهندسية',
    'ادارة المكتبة والنشاط الثقافي ',
    'ادارة الرحلات',
    'دارة الاسعاف',
    'ادارة الامن',
    'ادارة الخدمات المعاونة',
    'االدارة الفنية',
    'الادارة الفنية لحمام السباحة',
    'ادارة الحدائق والمكافح'
];

$factory->define(
    \App\Team::class,
    function(Faker\Generator $faker) use($departments) {
        return [
            'team_name' => $faker->randomElement($departments)
        ];
    }
);