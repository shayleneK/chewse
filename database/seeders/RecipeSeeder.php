<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('recipes')->insert([
            [
                'url' => 'https://www.bbcgoodfood.com/recipes/air-fryer-chicken-breasts',
                'image' => 'https://images.immediate.co.uk/production/volatile/sites/30/2022/04/Air-Fryer-Chicken-Breast-3121e78.jpg',
                'name' => 'Air fryer chicken breasts',
                'description' => 'Use an air fryer to create this tempting dish of tender chicken breasts coated in garlic, sweet paprika and herbs. Mix up the spices for interest or keep it plain if you prefer',
                'author' => 'Samuel Goldsmith',
                'ratings' => 5,
                'ingredients' => json_encode([
                    "4 chicken breasts",
                    "½ tbsp rapeseed oil",
                    "1 tsp salt",
                    "1 ½ tsp garlic granules",
                    "1 tsp smoked sweet paprika",
                    "2 tsp mixed herbs",
                    "½ tsp pepper",
                    "steamed rice and greens such as broccoli or green beans or a green salad, to serve (optional)"
                ]),
                'steps' => json_encode([
                    "Coat the chicken in the oil and set aside. In a bowl, combine the salt, garlic, paprika and mixed herbs with a good grinding of black pepper, then scatter onto a plate.",
                    "Roll each oiled chicken breast in the seasoning and put in your air fryer basket. Cook at 180C for 18-20 mins, turning after 10 mins. To check it is cooked, pierce the chicken with a knife at the thickest part to see if the juices run clear. Or insert a temperature thermometer and it should read 70C. Serve with rice and greens or a salad."
                ]),
                'nutrients' => json_encode(new \stdClass()),
                'times' => json_encode([
                    "Preparation" => "5 mins",
                    "Cooking" => "18 mins - 20 mins"
                ]),
                'serves' => 4,
                'difficult' => 'Easy',
                'vote_count' => 10,
                'subcategory' => 'Lunch recipes',
                'dish_type' => 'Quick lunch recipes',
                'maincategory' => 'recipes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url' => 'https://www.bbcgoodfood.com/recipes/falafel-burgers-0',
                'image' => 'https://images.immediate.co.uk/production/volatile/sites/30/2020/08/recipe-image-legacy-id-326597_11-b7385b9.jpg',
                'name' => 'Falafel burgers',
                'description' => "A healthy burger that's filling too. These are great for anyone after a satisfying bite low in calories.",
                'author' => 'Good Food team',
                'rattings' => 4,
                'ingredients' => json_encode([
                    "400g can  chickpeas, rinsed and drained",
                    "1 small red onion, roughly chopped",
                    "1 garlic clove, chopped ",
                    "handful of flat-leaf parsley  or curly parsley",
                    "1 tsp ground cumin",
                    "1 tsp ground coriander",
                    "½ tsp harissa paste  or chilli powder",
                    "2 tbsp plain flour",
                    "2 tbsp sunflower oil",
                    "toasted pitta bread, to serve",
                    "200g tub tomato salsa, to serve",
                    "green salad, to serve"
                ]),
                'steps' => json_encode([
                    "Drain the chickpeas and pat dry with kitchen paper. Tip into a food processor along with the onion, garlic, parsley, cumin, coriander, harissa paste, flour and a little salt. Blend until fairly smooth, then shape into four patties with your hands.",
                    "Heat the sunflower oil in a non-stick frying pan, and fry the burgers for 3 mins on each side until lightly golden. Serve with the toasted pitta bread, tomato salsa and green salad."
                ]),
                'nutrients' => json_encode([
                    "kcal" => "161",
                    "fat" => "8g",
                    "saturates" => "1g",
                    "carbs" => "18g",
                    "sugars" => "1g",
                    "fibre" => "3g",
                    "protein" => "6g",
                    "salt" => "0.4g"
                ]),
                'times' => json_encode([
                    "Preparation" => "10 mins",
                    "Cooking" => "6 mins"
                ]),
                'serves' => 4,
                'difficult' => 'Easy',
                'vote_count' => 710,
                'subcategory' => 'Lunch recipes',
                'dish_type' => 'Quick lunch recipes',
                'maincategory' => 'recipes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url' => 'https://www.bbcgoodfood.com/recipes/spicy-chicken-avocado-wraps',
                'image' => 'https://images.immediate.co.uk/production/volatile/sites/30/2020/08/spicychickenavocadowraps_5865-4035909.jpg',
                'name' => 'Spicy chicken & avocado wraps',
                'description' => "Pan-fry lean chicken breast with lime, chilli and garlic, then pile onto seeded tortilla wraps. Cool before assembling if packing for lunch",
                'author' => 'Sara Buenfeld',
                'rattings' => 4,
                'ingredients' => json_encode([
                    "1 chicken breast (approx 180g), thinly sliced at an angle",
                    "generous squeeze juice 0.5 lime",
                    "½ tsp mild chilli powder",
                    "1 garlic clove, chopped",
                    "1 tsp olive oil",
                    "2 seeded wraps",
                    "1 avocado, halved and stoned",
                    "1 roasted red pepper from a jar, sliced",
                    "a few sprigs coriander, chopped"
                ]),
                'steps' => json_encode([
                    "Mix the chicken with the lime juice, chilli powder and garlic.",
                    "Heat the oil in a non-stick frying pan then fry the chicken for a couple of mins – it will cook very quickly so keep an eye on it. Meanwhile, warm the wraps following the pack instructions or, if you have a gas hob, heat them over the flame to slightly char them. Do not let them dry out or they are difficult to roll.",
                    "Squash half an avocado onto each wrap, add the peppers to the pan to warm them through then pile onto the wraps with the chicken, and sprinkle over the coriander. Roll up, cut in half and eat with your fingers."
                ]),
                'nutrients' => json_encode([
                    "kcal" => "403",
                    "fat" => "16g",
                    "saturates" => "4g",
                    "carbs" => "32g",
                    "sugars" => "2g",
                    "fibre" => "5g",
                    "protein" => "29g",
                    "salt" => "0.8g"
                ]),
                'times' => json_encode([
                    "Preparation" => "5 mins",
                    "Cooking" => "8 mins"
                ]),
                'serves' => 2,
                'difficult' => 'Easy',
                'vote_count' => 81,
                'subcategory' => 'Lunch recipes',
                'dish_type' => 'Quick lunch recipes',
                'maincategory' => 'recipes',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
