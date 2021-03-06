<?php 

use RecipeFinder\Finder;

class FinderTest extends PHPUnit_Framework_TestCase
{
    /**
     * testfindRecipe
     *
     */
    public function testfindRecipe()
    {
        $fridgeItems[] = array('bread', '10', 'slices', '25/12/2014');
        $fridgeItems[] = array('cheese','10', 'slices', '25/12/2014');
        $fridgeItems[] = array('butter', '250', 'grams', '25/12/2014');
        $fridgeItems[] = array('peanut butter', '250', 'grams', '2/12/2014');
        $fridgeItems[] = array('mixed salad', '500', 'grams', '26/10/2014');        

        $recipes = array (
          0 => 
          array (
            'name' => 'grilled cheese on toast',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'cheese',
                'amount' => '2',
                'unit' => 'slices',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'salad sandwich',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'mixed salad',
                'amount' => '200',
                'unit' => 'grams',
              ),
            ),
          ),
        );

        $finder = new Finder($recipes, $fridgeItems);
        $dinner = $finder->findRecipe();
        $this->assertEquals("salad sandwich, grilled cheese on toast", $dinner);

    }

    /**
     * testAllExpired
     *
     */
    public function testAllExpired()
    {
        $fridgeItems[] = array('bread', '10', 'slices', '25/12/2013');
        $fridgeItems[] = array('cheese','10', 'slices', '25/12/2013');
        $fridgeItems[] = array('butter', '250', 'grams', '25/12/2013');
        $fridgeItems[] = array('peanut butter', '250', 'grams', '2/12/2013');
        $fridgeItems[] = array('mixed salad', '500', 'grams', '26/10/2014');        

        $recipes = array (
          0 => 
          array (
            'name' => 'grilled cheese on toast',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'cheese',
                'amount' => '2',
                'unit' => 'slices',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'salad sandwich',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'mixed salad',
                'amount' => '200',
                'unit' => 'grams',
              ),
            ),
          ),
        );

        $finder = new Finder($recipes, $fridgeItems);
        $dinner = $finder->findRecipe();
        $this->assertEquals("Order Takeout", $dinner);
    }
    
    /**
     * testAmount
     *
     */
    public function testAmount()
    {
        $fridgeItems[] = array('bread', '10', 'slices', '25/12/2014');
        $fridgeItems[] = array('cheese','10', 'slices', '25/12/2014');
        $fridgeItems[] = array('butter', '250', 'grams', '25/12/2014');
        $fridgeItems[] = array('peanut butter', '250', 'grams', '2/12/2014');
        $fridgeItems[] = array('mixed salad', '250', 'grams', '26/10/2014');        

        $recipes = array (
          0 => 
          array (
            'name' => 'grilled cheese on toast',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'cheese',
                'amount' => '2',
                'unit' => 'slices',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'salad sandwich',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'mixed salad',
                'amount' => '300',
                'unit' => 'grams',
              ),
            ),
          ),
        );

        $finder = new Finder($recipes, $fridgeItems);
        $dinner = $finder->findRecipe();
        $this->assertEquals("grilled cheese on toast", $dinner);
    }    

    /**
     * testEmptyFridgeItems
     *
     */
    public function testEmptyFridgeItems()
    {
        $recipes = array (
          0 => 
          array (
            'name' => 'grilled cheese on toast',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'cheese',
                'amount' => '2',
                'unit' => 'slices',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'salad sandwich',
            'ingredients' => 
            array (
              0 => 
              array (
                'item' => 'bread',
                'amount' => '2',
                'unit' => 'slices',
              ),
              1 => 
              array (
                'item' => 'mixed salad',
                'amount' => '200',
                'unit' => 'grams',
              ),
            ),
          ),
        );


         $finder = new Finder($recipes, array());
         $dinner = $finder->findRecipe();
         $this->assertEquals("Order Takeout", $dinner);

    }

    /**
     * testEmptyRecipes
     *
     */
    public function testEmptyRecipes()
    {
        $fridgeItems[] = array('bread', '10', 'slices', '25/12/2014');
        $fridgeItems[] = array('cheese','10', 'slices', '25/12/2014');
        $fridgeItems[] = array('butter', '250', 'grams', '25/12/2014');
        $fridgeItems[] = array('peanut butter', '250', 'grams', '2/12/2014');
        $fridgeItems[] = array('mixed salad', '250', 'grams', '26/10/2014');        
        
        $finder = new Finder(array(), $fridgeItems);
        $dinner = $finder->findRecipe();
        $this->assertEquals("Order Takeout", $dinner);

    }

    /**
     * testEmptyArrays
     *
     */
    public function testEmptyArrays()
    {
        $finder = new Finder(array(), array());
        $dinner = $finder->findRecipe();
        $this->assertEquals("Order Takeout", $dinner);
    }
}
