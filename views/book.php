 <?php

 $number = 1;
 if(!defined('SECURE_ACCESS')){
    die('Direct access not permitted');
}
require "assets/header.php";
 ?>



    <section class="py-10">
        <div class="container mx-auto text-center">
            <form action="" method="GET" class="mb-8">
                <input type="text" name="find"  placeholder="Search for books..." class="w-1/2 p-3 border border-gray-300 rounded-lg" required/>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Search</button>
            </form>
        </div>
    </section>
    <div class="table mx-auto text-center">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $book) : ?>
                    <tr>
                    <th><?=$number++?></th>
                    <th><?= $book->getTitle()?></th>
                    <th><?= $book->getAuthor()?></th>
                    <th><?= $book->getYear()?></th>

                    </tr>
            </tbody>
            <?php endforeach ?>
        </table>
    </div>
   
    <section class="py-20">
        <div class="container mx-auto text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
       
                <div class="bg-white p-8 shadow-md rounded-md">
                    <img src="photo/otak.jpeg" alt="Book Cover" class="mx-auto mb-4">
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800">Otak Kota</h3>
                        <p class="text-gray-600">Ratih Paradini</p>
                        <a href="#" class="block bg-blue-600 text-white mt-4 text-center py-2 rounded-lg hover:bg-blue-700">View Details</a>
                    </div>
                </div>
                <div class="bg-white p-8 shadow-md rounded-md">
                    <img src="photo/outus.jpeg" alt="Book Cover" class="mx-auto mb-1">
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800">Udah Putusin Aja</h3>
                        <p class="text-gray-600">by Felix Y. Siauw</p>
                        <a href="#" class="block bg-blue-600 text-white mt-4 text-center py-2 rounded-lg hover:bg-blue-700">View Details</a>
                    </div>
                </div>
                <div class="bg-white p-8 shadow-md rounded-md">
                    <img src="photo/hawariyu.jpeg" alt="Book Cover" class="mx-auto mb-4">
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800">Antara Dia aku & Mereka</h3>
                        <p class="text-gray-600">by Felix Y. Siauw</p>
                        <a href="#" class="block bg-blue-600 text-white mt-4 text-center py-2 rounded-lg hover:bg-blue-700">View Details</a>
                    </div>
                </div>

              
            </div>
        </div>
         
    </section>

<?php
require 'assets/footer.php';

?>