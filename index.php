<?php

session_start();
$product_ids = array();

if(isset($_POST['add_to_cart'])){

    if(!empty($_SESSION['shopping_cart'])){
        $count = count($_SESSION['shopping_cart']);
        $product_ids = array_column($_SESSION['shopping_cart'],'id');

        if(!in_array($_GET['id'],$product_ids)){

            $_SESSION['shopping_cart'][$count] = array
            (
                'id' => $_GET['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity']
            );
        }

        else{
            for($i=0; $i<count($product_ids); $i++){
            
                if($product_ids[$i] == $_GET['id']){
                    $_SESSION['shopping_cart'][$i]['quantity'] += $_POST['quantity'];
                }
            
            }
        }

    }

    else{
        
        $_SESSION['shopping_cart'][0] = array
        (

        'id' => $_GET['id'],
        'price' => $_POST['price'],
        'name' => $_POST['name'],
        'quantity' => $_POST['quantity']

        );
    }

}

if(filter_input(INPUT_GET,'action')=='delete'){
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if($product['id'] == $_GET['id']){

            unset($_SESSION['shopping_cart'][$key]);
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="php-style.css">
</head>
<body>
<header>    

<div class="search-form">
    <!-- <img src="search.png" alt=""> -->
    <div class="searchLogo">
    <input type="text" class="search-field" placeholder="Type Something...">
    <img src="search1.png" alt="" class="search-img">
</div>
    <div class="basket-container">
    <img src="basket1.png" alt="" class="basket">
    
    <?php
    if(isset($_SESSION['shopping_cart'])){
        if(count($_SESSION['shopping_cart'])>0){

        ?>
    <div class='dot'><?php echo count($_SESSION['shopping_cart']);?></div>
    <?php
    }
}
?>
    
</div>



</header>

<nav>

<ul class="nav-ul">

    <li data-target="#all" class="product-list active" id="all">ALL Products</li>
    <li data-target="#samsung" class="product-list" id="samsung">Samsung</li>
    <li data-target="#apple" class="product-list" id="apple">Apple</li>
    <li data-target="#google" class="product-list" id="google">Google</li>
    <li data-target="#nokia" class="product-list" id="nokia">Nokia</li>

</ul>

</nav>

<div class="flex-1">

    <?php

    $conn = mysqli_connect("localhost","giorgi","test123","giorgi_gudadze");

    $sql = "SELECT * FROM products ORDER BY id ASC";
    
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        while($product = mysqli_fetch_assoc($result)){
    ?>

    <div class="shop-cont">    
    <form class="form-shop" method="POST" action="index.php?action=add&id=<?php echo $product['id'];?>">
        <img src="<?php echo $product['image']; ?>" alt="">
        <h3><?php echo $product['name'];?></h3>
        <h4><?php echo $product['price'];?> $</h4>
        <input type="number" min="1" value="1" name="quantity" class="quantity-field">
        <input type="hidden" name="name" value="<?php echo $product['name'];?>">
        <input type="hidden" name="price" value="<?php echo $product['price'];?>">
        <input type="submit" name="add_to_cart" value="Add to Cart" class="add-btn">

    </form>
    </div>
    <?php
        }
    }
    ?>

</div>

<ul class="result-container-parent">

<ul class="result-container">

<ul class="title-ul">
    <li>Name</li>
    <li>Quantity</li>
    <li>Price</li>
    <li>Total</li>
    <li>Action</li>

</ul>
    <?php
    if(!empty($_SESSION['shopping_cart'])){
        $total = 0;

        foreach($_SESSION['shopping_cart'] as $key => $product){

    ?>
    <ul class='flex-2'>
    <li class="tabel-td"><?php echo $product['name'];?></li>
    <li class="tabel-td"><?php echo $product['quantity'];?></li>
    <li class="tabel-td"><?php echo $product['price'];?></li>
    <li class="tabel-td"><?php echo $product['quantity'] * $product['price']?></li>
    <li class="tabel-td">
    <a href="index.php?action=delete&id=<?php echo $product['id']?>">X</a>
    </li>
    </ul>
    <?php
    $total = $total + ($product['quantity'] * $product['price']);
        }
    
    ?>
    <ul class="flex-3">
        <li>Total</li>
        <li><?php echo $total; ?></li>
    </ul>
    <ul class="checkout-container">
        <div class="closeCheck">Close</div>
    <li>
    <?php
    if(isset($_SESSION['shopping_cart'])){
        if(count($_SESSION['shopping_cart'])>0){ 
    ?>
    <a href="add.php" class="button">Checkout</a>
        <?php }
    }?>
        </li>
        
        <?php } ?>
</ul>

</ul>

<script src="jquery.js"></script>
<script src="jquery.min.js"></script>

<script>

var navigationBar = document.querySelector('.nav-ul');
var brands = document.querySelectorAll('.product-list');

var h3Tags = document.querySelectorAll('h3');

navigationBar.addEventListener('click',function(e){
if(e.target.tagName='LI'){

    const currentBrand = document.querySelector(e.target.dataset.target);
    var getId = currentBrand.getAttribute('id');
    brands.forEach(function(brand){
        if(brand == currentBrand){

            brand.classList.add('active');

            var brandName = brand.textContent.toLowerCase();
            
            h3Tags.forEach(function(h){


                if(h.textContent.toLowerCase().indexOf(brandName)>-1){
                    h.parentElement.parentElement.style.display="block";
                }
                else{
                    h.parentElement.parentElement.style.display="none";
                }
                if(getId =="all"){

h.parentElement.parentElement.style.display="block";

}
            })

            
        }
        else{
            brand.classList.remove('active');
        }
    })

}

if($('html').height()<780){
    $('nav').css('height','100vh');
}
else{
    $('nav').css('height','calc(100% - 60px)');
}

})

var searchField = document.querySelector('.search-field');


    searchField.addEventListener('keyup',function(e){
    h3Tags.forEach(function(h){
        if(h.textContent.toLowerCase().indexOf(e.target.value.toLowerCase()) > -1){

            h.parentElement.parentElement.style.display="block";          
        }

        else{
            h.parentElement.parentElement.style.display="none";            
        }
    })
})


$('.basket-container').on('click',function(){

        $('.result-container-parent').css('overflow','visible');
        $(this).addClass('active');


})

$('.closeCheck').on('click',function(){
    $('.result-container-parent').css('overflow','hidden');
})

if($('html').height()<780){
    $('nav').css('height','100vh');
}
else{
    $('nav').css('height','calc(100% - 60px)');
}



</script>

</body>
</html>