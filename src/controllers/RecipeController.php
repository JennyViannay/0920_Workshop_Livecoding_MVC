<?php

namespace controllers;

require __DIR__ . '/../models/RecipeModel.php';

use models\RecipeModel;

class RecipeController
{
    private $recipeModel;

    public function __construct()
    {
        $this->recipeModel = new RecipeModel();
    }

    public function browse(): void
    {
        $recipes = $this->recipeModel->getAll();

        require __DIR__ . '/../views/index.php';
    }

    public function show(int $id)
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        if (false === $id || null === $id) {
            header("Location: /");
            exit("Wrong input parameter");
        }

        $recipe = $this->recipeModel->getById($id);

        if (!isset($recipe['title']) || !isset($recipe['description'])) {
            header("Location: /");
            exit("Recipe not found");
        }

        require __DIR__.'/../views/show.php';
    }

    public function add()
    {
        $errors = "";
        $recipe = null;

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if(!empty($_POST['title']) && !empty($_POST['description'])){
                $recipe = [
                    "title" => htmlspecialchars($_POST['title']),
                    'description' => htmlspecialchars($_POST['description'])
                ];
                $this->recipeModel->save($recipe);
                header('Location: /');
            } else {
                $errors = "Tous les champs sont requis";
            }
        }

        require __DIR__ . '/../views/form.php';
    }

    public function update(int $id)
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        if (false === $id || null === $id) {
            header("Location: /");
            exit("Wrong input parameter");
        }
        
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            if(!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['description'])){
                $recipe = [
                    "id" => intval($_POST['id']),
                    "title" => htmlspecialchars($_POST['title']),
                    'description' => htmlspecialchars($_POST['description'])
                ];
                $this->recipeModel->update($recipe);
                header("Location: /");
            } else {
                $errors = "Tous les champs sont requis";
            }
        }

        $recipe = $this->recipeModel->getById($id);
        
        require __DIR__ . '/../views/form.php';
    }

    public function delete(int $id)
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        if (false === $id || null === $id) {
            header("Location: /");
            exit("Wrong input parameter");
        }
        $this->recipeModel->delete($id);
        header("Location: /");
    }
}