<?php





if (!function_exists('getCityName')) {
    /**
     * Retrieve the city name based on the city ID.
     *
     * @param int $cityId The ID of the city to retrieve the name for.
     * @return string The name of the city, or an empty string if not found.
     */
    function getCityName(int $cityId): string
    {

        if (is_null($cityId)) {
            return ''; // Return an empty string or a default message
        }
        $city = DB::table('cities')->where('id', $cityId)->first();
        return $city->city ?? '';
    }
}

if (!function_exists('getStateName')) {
    /**
     * Retrieve the city name based on the city ID.
     *
     * @param int $stateId The ID of the city to retrieve the name for.
     * @return string The name of the city, or an empty string if not found.
     */
    function getStateName(int $stateId): string
    {
        $state = DB::table('states')->where('id', $stateId)->first();
        return $state->name ?? '';
    }


    // global function
    if (!function_exists('havePermission')) {
        function havePermission($route)
        {
            // Check if the user is authenticated
            if (auth()->check()) {
                // If the user is Super Admin (role_id == 9), grant all permissions
                if (auth()->user()->role_id == 9) {
                    return true; // Super Admin has all permissions
                }

                // For other users, check if they have the specific permission for the route
                $check = App\Models\PermissionRole::getPermissionRole($route, auth()->user()->role_id);
                return $check;
            }

            // If user is not authenticated, return false
            return false;
        }
    }





    // 
    // public static function hasStock($entityId, $entityType)
    // {
    //     $now = now(); // Current date and time

    //     if ($entityType === 'product') {
    //         $stockQuantity = Stock::where('product_id', $entityId)
    //             ->where('expiry_date', '>', $now) // Check if stock is not expired
    //             ->sum('quantity');
    //     } elseif ($entityType === 'category') {
    //         $stockQuantity = Stock::where('category', $entityId)
    //             ->where('expiry_date', '>', $now) // Check if stock is not expired
    //             ->sum('quantity');
    //     } else {
    //         return false;
    //     }

    //     return $stockQuantity > 0;
    // }
}
