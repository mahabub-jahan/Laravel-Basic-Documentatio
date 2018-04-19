<?php

    public function editRestaurantInfo(Request $request)
    {


        $restaurant_logo = $restaurantInfo->restaurant_logo;



        if ($request->file('restaurant_logo')) {
            @unlink($restaurant_logo);


            $restaurant_logo = $request->file('restaurant_logo');
            $uniqueName = substr(bcrypt(time()),'0','10');
            $uniqueImageName = $uniqueName.'.'.$restaurant_logo->getClientOriginalExtension();
            $directory = 'images/restaurant-image/restaurant-logo/';
            $imageUrl = $directory.$uniqueImageName;
            // $restaurant_logo->move($directory.$uniqueImageName);
            Image::make($restaurant_logo)->save($imageUrl);


            $restaurantInfo->restaurant_logo = $imageUrl;
        } else {
            $restaurantInfo->restaurant_logo = $restaurant_logo;
        }

       
        $restaurantInfo->save();
        return redirect()->back()->with('message', 'Restaurant Info Update Successfully');
    }

?>

