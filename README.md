# Chewse: AI Assistant Application for Improving Cooking Confidence

Chewse allows users to improve their cooking confidence by providing contextualized feedback and suggestions based on their input and current recipe progress. With this, the user's confidence level is also automatically updated based on the sentiment of their questions toward the AI. The confidence of a user in their questions has a weight of 15% towards their confidence level.

After user completes the recipe, the user provides feedback on their experience working on the recipe. This feedback is used to update the confidence level of the user with a weight of 40%.

When a user is near levelling up/down the Chewse application will challenge the user to try a harder task or take it easy with an easier task.

## Requirements

-   Laravel Herd installed (https://herd.laravel.com)
-   PHP 8.2+
-   Composer

## Setup Instructions

1. Open Laravel Herd and place the "app" folder in your Herd sites directory.
2. Open a terminal and navigate to the app folder:
   cd app
3. Install dependencies:
   composer install
4. Copy the environment file:
   cp .env.example .env
5. Generate the application key:
   php artisan key:generate
6. Run migrations (if needed):
   php artisan migrate
7. Visit the site in your browser:
   http://chewse.test (or your Herd site URL)

## Usage

-   Browse the recipes.
-   Start a recipe and follow steps.
-   Submit feedback after completing a recipe.
