<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('recipes')->insert([
            //Easy
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
            ],
            [
                'url' => 'https://www.example.com/recipes/breakfast-pizza',
                'image' => 'https://d21klxpge3tttg.cloudfront.net/wp-content/uploads/2022/04/Breakfast-Pizza-.jpg',
                'name' => 'Breakfast Pizza',
                'description' => "This recipe calls for the crust to be prebaked a bit before adding ingredients. Feel free to change sausage to ham or bacon. This warms well in the microwave for those late risers.",
                'author' => 'Unknown',
                'rattings' => 4, // Adjusted manually (no rating provided)
                'ingredients' => json_encode([
                    'prepared pizza crust',
                    'sausage patty',
                    'eggs',
                    'milk',
                    'salt and pepper',
                    'cheese'
                ]),
                'steps' => json_encode([
                    'preheat oven to 425 degrees f',
                    'press dough into the bottom and sides of a 12 inch pizza pan',
                    'bake for 5 minutes until set but not browned',
                    'cut sausage into small pieces',
                    'whisk eggs and milk in a bowl until frothy',
                    'spoon sausage over baked crust and sprinkle with cheese',
                    'pour egg mixture slowly over sausage and cheese',
                    's& p to taste',
                    'bake 15-20 minutes or until eggs are set and crust is brown'
                ]),
                'nutrients' => json_encode([
                    'kcal' => '173.4',
                    'fat' => '18g',
                    'saturates' => '0g',
                    'carbs' => '17g',
                    'sugars' => '22g',
                    'fibre' => '35g',
                    'protein' => '1g',
                    'salt' => '0g' // Assumed missing
                ]),
                'times' => json_encode([
                    'Preparation' => '10 mins', // Estimated based on step content
                    'Cooking' => '20 mins'
                ]),
                'serves' => 6,
                'difficult' => 'Medium',
                'vote_count' => 9,
                'subcategory' => 'Breakfast',
                'dish_type' => 'Pizza',
                'maincategory' => 'recipes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url' => 'https://www.example.com/recipes/chinese-chop-suey',
                'image' => 'https://www.licious.in/blog/wp-content/uploads/2021/01/American-Chopsuey.jpg',
                'name' => 'Chinese Chop Suey',
                'description' => 'Easy one‑pot dinner.',
                'author' => 'Unknown',
                'ratings' => 4, // assuming 8 votes average ~4
                'ingredients' => json_encode([
                    'celery',
                    'onion',
                    'ground pork',
                    'soy sauce',
                    'beef broth',
                    'cooking oil',
                    'hamburger buns'
                ]),
                'steps' => json_encode([
                    'brown ground meat and onion in a large pot',
                    'add 1/4 cup of soy sauce',
                    'thinly slice the entire bunch of celery, including the leaves',
                    'add beef broth and celery',
                    'bring to a boil',
                    'reduce heat and simmer until celery is tender',
                    'add more soy sauce if needed, to taste',
                    'serve as an open face sandwich over a hamburger bun'
                ]),
                'nutrients' => json_encode([
                    'kcal' => '395.4',
                    'fat' => '31g',
                    'saturates' => '20g',
                    'carbs' => '29g',
                    'sugars' => '51g',
                    'fibre' => '33g',
                    'protein' => '8g',
                    'salt' => '—' // not provided
                ]),
                'times' => json_encode([
                    'Preparation' => '10 mins',  // estimated prep
                    'Cooking' => '60 mins'        // from total time 70 min
                ]),
                'serves' => 7,
                'difficult' => 'Medium', // inferred from tags and description
                'vote_count' => 8,
                'subcategory' => 'Dinner recipes',
                'dish_type' => 'One‑dish meal',
                'maincategory' => 'recipes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url' => 'https://www.example.com/recipes/global-gourmet-taco-casserole',
                'image' => 'https://www.thereciperebel.com/wp-content/uploads/2023/12/taco-casserole-TRR-34-of-38.jpg',
                'name' => 'Global Gourmet Taco Casserole',
                'description' => "Hey! I found this in a cookbook recognizing global foods. My brother made it in 7th grade food‑science class and everyone loved it. This can be served with warm flour tortillas and toppings like guacamole, tomatoes, or sour cream—your choice!",
                'author' => 'Unknown',
                'ratings' => 5, // 11 votes ~5 stars
                'ingredients' => json_encode([
                    'ground beef',
                    'onion',
                    'tomato sauce',
                    'taco sauce',
                    'salt',
                    'pepper',
                    'tabasco sauce',
                    'hot chili pepper',
                    'cornmeal',
                    'whole kernel corn',
                    'sliced ripe olives',
                    'cheddar cheese'
                ]),
                'steps' => json_encode([
                    'heat oven to 375 degrees',
                    'brown ground beef and onion over medium heat',
                    'drain',
                    'stir in tomato sauce, taco or other sauce, salt, pepper, tabasco, chiles, and cornmeal, adjusting for "hot" taste preference and desired thickness',
                    'stir in more cornmeal, if desired',
                    'stir in corn and olives',
                    'transfer mixture to casserole dish',
                    'cover and bake for 30 to 40 minutes, or until bubbly and heated through',
                    'top with cheese immediately on removing from oven so cheese melts',
                    'garnish with corn chips just before serving to keep them crisp',
                    'serve with a cool fresh vegetable such as cucumber slices, avocado, or lettuce leaves, if desired'
                ]),
                'nutrients' => json_encode([
                    'kcal' => '456.8',
                    'fat' => '40g',
                    'saturates' => '34g',
                    'carbs' => '67g',
                    'sugars' => '57g',
                    'fibre' => '51g',
                    'protein' => '9g',
                    'salt' => '—' // not provided
                ]),
                'times' => json_encode([
                    'Preparation' => '15 mins',  // estimated from total 55 min
                    'Cooking' => '40 mins'
                ]),
                'serves' => 12,
                'difficult' => 'Hard',
                'vote_count' => 11,
                'subcategory' => 'Casseroles',
                'dish_type' => 'One‑dish meal',
                'maincategory' => 'recipes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'url' => 'https://www.example.com/recipes/turkey-meatloaf-sundried-feta',
                'image' => 'https://images.getrecipekit.com/20220610044227-IMG_0446-e1569301102692-scaled.jpg?aspect_ratio=1:1&quality=90&',
                'name' => 'Turkey Meatloaf with Sun-Dried Tomatoes and Feta',
                'description' => "This is delicious! I really don't care for meatloaf but my DH and 3 sons love it, so I came up with this healthy recipe. I'm all about the flavor, and this recipe is a very creative, gourmet combination. (Don’t bother with store-bought breadcrumbs—just leave a piece of bread on the counter covered with a paper towel for a few hours, then crumble.)",
                'author' => 'Unknown',
                'ratings' => 4, // 9 votes ~4 stars (based on vote_count)
                'ingredients' => json_encode([
                    'plain breadcrumbs',
                    'fresh flat-leaf parsley',
                    'sun-dried tomato',
                    'garlic cloves',
                    'eggs',
                    'whole milk',
                    'feta',
                    'kosher salt',
                    'fresh ground black pepper',
                    'ground turkey'
                ]),
                'steps' => json_encode([
                    'Place oven rack in the center of the oven',
                    'Preheat the oven to 375°F',
                    'Spray a 9 by 5 inch loaf pan with cooking spray',
                    'In a large bowl, stir together the bread crumbs, parsley, sun-dried tomatoes, garlic, eggs, milk, feta, salt, and pepper',
                    'Add the turkey and gently stir to combine, being careful not to overwork the meat',
                    'Carefully pack the mixture into the prepared pan and bake until the internal temperature registers 165°F on an inserted thermometer, about 45 minutes',
                    'Remove the loaf, empty the juices that have accumulated on the top, then put it back in the oven on broil for about 5 minutes so the top browns nicely',
                    'Remove from oven and let rest for 5 minutes',
                    'Serve with a big, colorful salad'
                ]),
                'nutrients' => json_encode([
                    'kcal' => '218.2',
                    'fat' => '17g',
                    'saturates' => '9g',
                    'carbs' => '26g',
                    'sugars' => '37g',
                    'fibre' => '21g',
                    'protein' => '3g',
                    'salt' => '—'
                ]),
                'times' => json_encode([
                    'Preparation' => '15 mins',
                    'Cooking' => '45 mins'
                ]),
                'serves' => 9,
                'difficult' => 'Medium',
                'vote_count' => 9,
                'subcategory' => 'Meatloaf',
                'dish_type' => 'Main dish',
                'maincategory' => 'recipes',
                'created_at' => now(),
                'updated_at' => now(),
            ],



        ]);
    }
}
