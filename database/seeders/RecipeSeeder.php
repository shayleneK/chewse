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
                'url' => 'https://panlasangpinoy.com/chicken-sopas-soup-recipe/',
                'image' => 'https://i.pinimg.com/736x/46/dc/18/46dc18ba4538806b8b52a1d4010b91a4.jpg',
                'name' => 'Chicken Sopas Soup',
                'description' => 'A comforting Filipino chicken noodle soup with vegetables and milk, perfect for cold days or when feeling under the weather.',
                'ingredients' => json_encode([
                    '3 tablespoons butter',
                    '1 medium-sized onion diced',
                    '1 lb boneless skinless chicken breast diced',
                    '32 ounces chicken broth (about 4 cups)',
                    '2 cups elbow macaroni',
                    '3/4 cup celery stalk chopped',
                    '3/4 cup carrots diced',
                    '3/4 cup cabbage shredded',
                    '3/4 cup fresh or evaporated milk',
                    '1 cup water',
                    'Salt and ground black pepper to taste'
                ]),
                'steps' => json_encode([
                    "Heat a cooking pot and put in the butter. Allow the butter to melt.",
                    "Add onions and cook until the texture becomes soft.",
                    "Put in the boneless chicken breasts and cook for 3 to 5 minutes.",
                    "Sprinkle some salt and ground black pepper and stir.",
                    "Add chicken broth and bring to a boil.",
                    "Pour in water and milk and wait to re-boil. Simmer for 15 to 20 minutes.",
                    "Add the elbow macaroni and cook for 8 minutes while stirring once in a while.",
                    "Put in the carrots and celery and simmer for 3 minutes.",
                    "Add the cabbage and cook for 2 minutes more.",
                    "Turn off the heat and transfer to a serving plate.",
                    "Serve hot. Share and enjoy!"
                ]),
                'difficulty' => 'Easy'
            ],
            [
                'url' => 'https://kitchenconfidante.com/wprm_print/filipino-chicken-adobo',
                'image' => 'https://www.kawalingpinoy.com/wp-content/uploads/2021/07/chicken-pork-adobo-1.jpg', // Replace with the actual image URL if available
                'name' => 'Filipino Chicken Adobo',
                'description' => 'A classic Filipino dish featuring chicken marinated in soy sauce, vinegar, garlic, and spices, then simmered until tender and flavorful.',
                'ingredients' => json_encode([
                    '8 chicken thighs (on the bone, skin on or off)',
                    '1/3 cup soy sauce (prefer Silver Swan for this recipe)',
                    '1/3 cup apple cider vinegar',
                    '1 small head of garlic (mashed or finely minced)',
                    'freshly ground black pepper',
                    '3 bay leaves',
                    '1 tablespoon canola oil',
                    '1 Thai chili pepper (optional)'
                ]),
                'steps' => json_encode([
                    "Marinate the chicken in soy sauce, vinegar, garlic, and pepper in a non-reactive bowl for 30 minutes to 1 hour, rotating at least once. If you can marinate overnight, even better.",
                    "Place the chicken, marinade, bay leaves, and chili (if using) in a deep-sided sauté pan and place over medium heat.",
                    "When the sauce begins to bubble, turn the chicken and cook until the meat is nearly cooked through, about 15 minutes.",
                    "Transfer the sauce to a bowl, add oil to the pan, and brown the chicken on all sides, working in batches.",
                    "Return the sauce to the pan, bring to a boil, and lower the heat to a simmer. Cover and simmer for about 20-30 minutes, or until the chicken is tender and the sauce is thick and deep in color. If you lose track of time and/or find that the sauce has reduced too much, add a touch of water to the sauce.",
                    "Serve hot over rice."
                ]),
                'difficulty' => 'Easy'
            ],
            [
                'url' => 'https://www.themealdb.com/meal/53069-bistek-recipe',
                'image' => 'https://sundaysuppermovement.com/wp-content/uploads/2023/12/bistek-featured.jpg',
                'name' => 'Bistek',
                'description' => 'Filipino-style beef steak with onions and soy sauce, a popular comfort food dish that\'s savory and slightly sweet.',
                'ingredients' => json_encode([
                    '2 lbs beef round slice thin',
                    '1 large onion sliced',
                    '1/2 cup soy sauce',
                    '1/4 cup lemon juice',
                    '3 cloves garlic crushed',
                    '1 teaspoon sugar',
                    '1/2 teaspoon salt',
                    '1/4 teaspoon pepper',
                    '3 tablespoons cooking oil',
                    '1 cup water',
                    'Steamed rice for serving'
                ]),
                'steps' => json_encode([
                    "In a bowl, combine soy sauce, lemon juice, garlic, sugar, salt, and pepper.",
                    "Add the thinly sliced beef and marinate for at least 30 minutes.",
                    "Heat cooking oil in a pan over medium heat.",
                    "Sauté the onions until soft and translucent.",
                    "Add the marinated beef (reserve the marinade) and cook until the color changes.",
                    "Pour the reserved marinade and water, then bring to a boil.",
                    "Simmer for 30-40 minutes until the meat is tender.",
                    "Serve hot with steamed rice."
                ]),
                'difficulty' => 'Easy'
            ],
            [
                'url' => 'https://www.themealdb.com/meal/52813-kentucky-fried-chicken-recipe',
                'image' => 'https://www.themealdb.com/images/media/meals/xqusqy1487348868.jpg',
                'name' => 'Kentucky Fried Chicken',
                'description' => 'Crispy fried chicken recipe inspired by the famous KFC original recipe with a blend of 11 herbs and spices.',
                'ingredients' => json_encode([
                    '1 whole chicken',
                    '2 cups flour',
                    '1 tablespoon salt',
                    '1/2 teaspoon black pepper',
                    '1 tablespoon paprika',
                    '1 teaspoon garlic salt',
                    '1 teaspoon chili powder',
                    '2 eggs',
                    '2 cups buttermilk',
                    'Oil for frying'
                ]),
                'steps' => json_encode([
                    "Mix the flour, salt, pepper, paprika, garlic salt, and chili powder in a large bowl.",
                    "Add the buttermilk to the eggs in a separate bowl and whisk together.",
                    "Dip the chicken pieces in the egg mixture, then coat thoroughly with the seasoned flour.",
                    "Let the coated chicken rest for 10 minutes.",
                    "Heat oil in a deep fryer to 350°F (175°C).",
                    "Fry chicken until golden brown and cooked through (12-15 minutes for pieces, 25-30 minutes for whole chicken).",
                    "Drain on paper towels and serve hot."
                ]),
                'difficulty' => 'Medium'
            ],
            [
                'url' => 'https://www.themealdb.com/meal/52831-chicken-karaage-recipe',
                'image' => 'https://www.themealdb.com/images/media/meals/tyywsw1505930373.jpg',
                'name' => 'Chicken Karaage',
                'description' => 'Japanese fried chicken pieces marinated in soy sauce, ginger, and garlic, then coated in potato starch and deep fried until crispy.',
                'ingredients' => json_encode([
                    '1 lb chicken thigh fillets cut into bite-sized pieces',
                    '3 tablespoons soy sauce',
                    '2 tablespoons sake',
                    '2 tablespoons mirin',
                    '1 tablespoon sugar',
                    '1 teaspoon grated ginger',
                    '1 clove garlic minced',
                    '1/2 cup potato starch',
                    'Oil for deep frying',
                    '1 tablespoon flour for dusting'
                ]),
                'steps' => json_encode([
                    "In a bowl, combine soy sauce, sake, mirin, sugar, ginger, and garlic to make the marinade.",
                    "Add the chicken pieces to the marinade and mix well.",
                    "Cover and refrigerate for at least 1 hour (preferably overnight).",
                    "Remove chicken from marinade and pat dry with paper towels.",
                    "Lightly dust the chicken pieces with flour.",
                    "Coat the chicken pieces evenly with potato starch.",
                    "Heat oil to 350°F (175°C) in a deep fryer or heavy pot.",
                    "Fry chicken in batches until golden brown and cooked through (about 4-5 minutes).",
                    "Drain on paper towels and serve hot with lemon wedges and steamed rice."
                ]),
                'difficulty' => 'Medium'
            ],
            [
                'url' => 'https://panlasangpinoy.com/pork-sinigang-recipe/',
                'image' => 'https://panlasangpinoy.com/wp-content/uploads/2022/09/pork-sinigang-panlasang-pinoy.jpg',
                'name' => 'Pork Sinigang',
                'description' => 'A sour and savory Filipino soup made with pork, vegetables, and tamarind broth - a comforting classic that balances tangy, salty, and umami flavors.',
                'ingredients' => json_encode([
                    '2 lbs pork shoulder cut into chunks',
                    '1 pack sinigang mix (tamarind base)',
                    '1 onion sliced',
                    '6 cloves garlic minced',
                    '1 radish sliced',
                    '2 tomatoes quartered',
                    '1 cup long green beans cut in 2 inch pieces',
                    '1 cup eggplant sliced',
                    '1 cup kangkong (water spinach)',
                    '3 tablespoons cooking oil',
                    '8 cups water',
                    'Salt and pepper to taste',
                    '1 chili pepper optional'
                ]),
                'steps' => json_encode([
                    "Heat oil in a large pot and sauté garlic and onions until fragrant.",
                    "Add pork chunks and cook until lightly browned on all sides.",
                    "Pour in water and bring to a boil, then reduce heat and simmer for 1 hour until pork is tender.",
                    "Add sinigang mix and stir until completely dissolved.",
                    "Add radish and tomatoes, then simmer for 5 minutes.",
                    "Add long green beans and eggplant, cook for another 5 minutes.",
                    "Season with salt and pepper to taste.",
                    "Add kangkong and chili pepper (if using) and cook for 2 minutes until vegetables are tender.",
                    "Serve hot with steamed rice."
                ]),
                'difficulty' => 'Medium'
            ],
            [
                'url' => 'https://panlasangpinoy.com/lechon-kawali-recipe/',
                'image' => 'https://www.kawalingpinoy.com/wp-content/uploads/2014/10/crispy-lechon-kawali-4.jpg',
                'name' => 'Lechon Kawali',
                'description' => 'Crispy deep-fried pork belly with crackling skin, a beloved Filipino party dish that requires precise technique and timing.',
                'ingredients' => json_encode([
                    '2 lbs pork belly skin on',
                    '1/2 cup soy sauce',
                    '1/4 cup vinegar',
                    '6 cloves garlic crushed',
                    '1 onion sliced',
                    '3 bay leaves',
                    '1 tablespoon peppercorns',
                    '1 cup water',
                    'Oil for deep frying',
                    'Salt for seasoning'
                ]),
                'steps' => json_encode([
                    "Score the pork skin in a cross-hatch pattern without cutting through to the meat.",
                    "Combine soy sauce, vinegar, garlic, onion, bay leaves, peppercorns, and water in a pot.",
                    "Add pork belly and marinate for 1 hour, then simmer covered for 1.5 hours until tender.",
                    "Remove pork from liquid and let cool completely in the refrigerator for at least 4 hours or overnight.",
                    "Heat oil to 325°F (160°C) and fry pork belly until golden brown (first fry).",
                    "Remove and drain, then increase oil temperature to 375°F (190°C).",
                    "Fry again for 2-3 minutes until skin is crispy and bubbly.",
                    "Drain on paper towels, season with salt, and serve with dipping sauce."
                ]),
                'difficulty' => 'Hard'
            ],
            [
                'url' => 'https://panlasangpinoy.com/kare-kare-recipe/',
                'image' => 'https://www.kawalingpinoy.com/wp-content/uploads/2014/01/kare-kare-with-oxtail-1.jpg',
                'name' => 'Kare-Kare',
                'description' => 'Rich and creamy Filipino oxtail stew with vegetables, served with bagoong (fermented shrimp paste) - a complex dish requiring patience and skill.',
                'ingredients' => json_encode([
                    '3 lbs oxtail cut in 2 inch slices',
                    '1 lb beef tripe cleaned and sliced',
                    '1/2 lb string beans cut in 2 inch length',
                    '2 pcs eggplants sliced',
                    '1 banana heart sliced',
                    '1 cup peanut butter smooth',
                    '1/2 cup toasted rice powder',
                    '1/4 cup annatto seeds soaked in 1 cup water',
                    '1 large onion chopped',
                    '1 head garlic minced',
                    '6 cups beef broth',
                    '3 tablespoons cooking oil',
                    'Salt and pepper to taste'
                ]),
                'steps' => json_encode([
                    "Boil oxtail and tripe in separate pots until tender (2-3 hours), reserving broth.",
                    "In a large pot, heat oil and sauté garlic and onions until fragrant.",
                    "Add annatto water (strained) and bring to a boil.",
                    "Add peanut butter and whisk until fully incorporated.",
                    "Add toasted rice powder and beef broth, simmer for 30 minutes.",
                    "Add cooked oxtail and tripe, simmer for another 15 minutes.",
                    "Add vegetables (string beans, eggplant, banana heart) and cook until tender.",
                    "Season with salt and pepper, serve hot with bagoong and steamed rice."
                ]),
                'difficulty' => 'Hard'
            ],
            [
                'url' => 'https://panlasangpinoy.com/crispy-pata-recipe/',
                'image' => 'https://www.foxyfolksy.com/wp-content/uploads/2019/12/crispy-pata-640.jpg',
                'name' => 'Crispy Pata',
                'description' => 'Deep-fried pork hock with crispy skin and tender meat, a show-stopping Filipino dish that requires careful preparation and double frying.',
                'ingredients' => json_encode([
                    '1 whole pork hock (leg)',
                    '1/2 cup soy sauce',
                    '1/4 cup vinegar',
                    '1/4 cup calamansi juice',
                    '8 cloves garlic crushed',
                    '1 onion sliced',
                    '3 bay leaves',
                    '1 tablespoon peppercorns',
                    '2 cups water',
                    'Oil for deep frying',
                    '1 cup all-purpose flour',
                    '1 egg beaten',
                    'Salt and pepper to taste'
                ]),
                'steps' => json_encode([
                    "Score the pork skin deeply in a diamond pattern without cutting into the meat.",
                    "Combine soy sauce, vinegar, calamansi juice, garlic, onion, bay leaves, peppercorns, and water.",
                    "Marinate pork hock for 1 hour, then simmer covered for 2 hours until meat is tender.",
                    "Remove from liquid and let cool completely, then refrigerate for 4 hours or overnight.",
                    "Prepare breading station with flour and beaten egg.",
                    "Coat the chilled pork hock with flour, dip in egg, then coat with flour again.",
                    "Heat oil to 325°F (160°C) and fry for 15 minutes until golden.",
                    "Increase oil temperature to 375°F (190°C) and fry for another 8-10 minutes until very crispy.",
                    "Drain on wire rack, season with salt and pepper, and serve hot."
                ]),
                'difficulty' => 'Hard'
            ],
            [
                'url' => 'https://example.com/brown-butter-recipe', // Replace with the actual URL if available
                'image' => 'https://example.com/brown-butter.jpg', // Replace with the actual image URL if available
                'name' => 'Brown Butter',
                'description' => 'A nutty and flavorful butter that enhances the taste of baked goods. This simple process takes only a few minutes and adds depth to your recipes.',
                'ingredient' => json_encode([
                    '12 Tbsp. unsalted butter (cut into pieces)',
                    '1 cup dark brown sugar (packed, light brown will be ok too)',
                    '1/2 cup granulated sugar',
                    '1 large egg (room temperature)',
                    '1 large egg yolk (room temperature)',
                    '2 Tbsp. whole milk',
                    '1 Tbsp. pure vanilla extract',
                    '2 2/3 cups all-purpose flour (spooned and leveled)',
                    '1 tsp. salt',
                    '1 tsp. baking soda',
                    '1/2 tsp. baking powder',
                    '2, 4 oz. bars semi-sweet chocolate, chopped, divided',
                    'flaky sea salt, for finishing'
                ]),
                'steps' => json_encode([
                    "Use a stainless steel skillet. This is best to easily monitor the butter's color and gauge when the butter has browned.",
                    "Place the unsalted butter in the cold, stainless steel skillet. Unsalted is truly best because salted butter foams more.",
                    "Melt the butter over medium heat. Swirl the pan occasionally to help the butter melt evenly. As the butter melts, it separates into butter fat and milk solids. The milk solids will naturally sink to the bottom of the pan and begin to brown as they heat up.",
                    "You'll notice the butter begin to foam. This is good! The foam will begin to subside.",
                    "Use a heat-resistant spatula to continually gently stir the butter. You'll begin to see tiny specks at the bottom of the pan, constantly stir and scrape so these don't stick. (These are the milk solids that give brown butter its yummy flavor.)",
                    "As soon as the butter turns chestnut brown and emits a nutty aroma, remove the pan from the heat and scrape the brown butter and all of the yummy brown bits into a heat-proof bowl. It's important to remove to a bowl immediately so the residual heat from the pan doesn't burn the butter.",
                    "Depending on your heat setting, this process should only take less than 10 minutes."
                ]),
                'difficulty' => 'Easy'
            ]



        ]);
    }
}
