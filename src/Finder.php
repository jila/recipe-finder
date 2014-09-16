<?php
/**
 *
 * This class gets two arguments fridge items and recipe 
 * both in array and generates the best recipe base on fridge items
 *
 */

namespace RecipeFinder;

class Finder {

    public $recipes;
    public $fridgeItems;
    public $dinner;

    /**
     * __construct
     *
     * @param array  $recipes
     * @param object $fridgeItems
     */
    public function __construct($recipes, $fridgeItems)
    {
        $this->recipes     = $recipes;   
        $this->fridgeItems = $fridgeItems;
    }

    public function findRecipe()
    {
        foreach ($this->fridgeItems as $fridgeItem) {
            // First check if the item is expired
            $date  = \DateTime::createFromFormat('d/m/Y', $fridgeItem[3]);
            $today = new \DateTime();

            $interval = $today->diff($date);
            $days     = $interval->format('%R%a'); 
                
            if ($days < 0 ) {
                continue;
            }

            $availableItems[trim(strtolower($fridgeItem[0]))] = array('amount' => $fridgeItem[1],
                                                                      'unit'   => $fridgeItem[2],
                                                                      'days'   => $days
                                                                      ); 
        }

        $dinner = array();

        foreach ($this->recipes as $recipes) {
            $days = 0;

            foreach ($recipes['ingredients'] as $ingredients) {
                $item = trim(strtolower($ingredients['item']));
                
                if (!array_key_exists($item, $availableItems)) {
                    continue 2;
                }

                if ($ingredients['amount'] > $availableItems[$item]['amount'] || $availableItems[$item]['unit'] != $ingredients['unit']){
                    continue 2;
                } 
                
                // The recipe with less days should be the first suggestion
                $days += $availableItems[$item]['days'];
            }

            $dinner[$recipes['name']] = $days;
        }

        if (empty($dinner)) {
            return "Order Takeout";
        }

        asort($dinner);
        
        $dinner = array_keys($dinner);
        return implode(', ', $dinner);
    }
}
