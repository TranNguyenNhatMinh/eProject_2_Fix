<?php
// Experience data - shared across pages
$experiences = [
    'penguin-encounter' => [
        'title' => 'Penguin Encounter',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 90.00,
        'image' => 'img/body/cardp1.jpg',
    ],
    'yoga' => [
        'title' => 'All-Level Yoga',
        'category' => 'FITNESS',
        'price' => 25.00,
        'image' => 'img/body/cardp2.png',
    ],
    'penguins-pancakes' => [
        'title' => 'Penguins & Pancakes',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 45.00,
        'image' => 'img/body/cardp3.png',
    ],
    'otter-encounter' => [
        'title' => 'Otter Encounter',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 85.00,
        'image' => 'img/body/cardp4.jpg',
    ],
    'marine-life-tour' => [
        'title' => 'Marine Life Tour',
        'category' => 'EDUCATIONAL TOURS',
        'price' => 35.00,
        'image' => 'img/body/cardp5.jpg',
    ],
    'aquarium-behind-scenes' => [
        'title' => 'Aquarium Behind Scenes',
        'category' => 'BEHIND THE SCENES',
        'price' => 55.00,
        'image' => 'img/body/cardp6.jpg',
    ],
    'shark-encounter' => [
        'title' => 'Shark Encounter',
        'category' => 'ANIMAL MEET & GREETS',
        'price' => 95.00,
        'image' => 'img/body/cardp7.jpg',
    ],
    'family-fun-day' => [
        'title' => 'Family Fun Day',
        'category' => 'FAMILY EVENTS',
        'price' => 60.00,
        'image' => 'img/body/cardp8.jpg',
    ],
    // Events (from event-detail - registerable)
    'junior-keepers' => [
        'title' => 'JUNIOR KEEPERS (11-15 YEARS OLD)',
        'category' => 'EVENT',
        'price' => 100.00,
        'image' => 'img/body/junior.png',
    ],
    'yoga-event' => [
        'title' => 'YOGA',
        'category' => 'EVENT',
        'price' => 30.00,
        'image' => 'img/body/yoga.png',
    ]
];

function getExperienceBySlug($slug) {
    global $experiences;
    return $experiences[$slug] ?? null;
}
?>
