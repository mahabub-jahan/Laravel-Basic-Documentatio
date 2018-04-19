<?php



public function saveRestaurantSubImages(Request  $request)
    {

        $this->validate($request, [
            'sub_image' => 'required',

        ]);



         $subImages = $request->file('sub_image');
        foreach ($subImages as $subImage) {
            $uniqueSubName = substr(bcrypt(md5(random_int(1,10000))),'0','10');
            $subUniqueImageName =$uniqueSubName.'.'.$subImage->getClientOriginalExtension();
            $subImagedirectory = 'images/restaurant-image/restaurant-sub-images/';
            $subImageUrl = $subImagedirectory.$subUniqueImageName;
            Image::make($subImage)->save($subImageUrl);

            $subImage = new RestaurantSubImage();
            $subImage->restaurant_unique_id = Auth::user()->unique_id;
            $subImage->sub_image = $subImageUrl;
            $subImage->save();
        }

        return redirect()->back()->with('message', 'Restaurant Slider Images Inserted Successfully');
    }




    public function destroyRestaurantSubImages($id)
    {

        $deleteRestaurantSubImage = RestaurantSubImage::find($id);
        @unlink($deleteRestaurantSubImage->sub_image);

        $deleteRestaurantSubImage->delete();
        return redirect()->back()->with('destroy','Restaurant Slider Image Delete Successfully !');
    }

    

?>