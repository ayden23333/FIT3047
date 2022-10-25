<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $product
 */
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="New.css" rel="stylesheet">
    <title>Flatbread</title>
    <style>
        .button{
            background-color: #fac45f;
            float: right;

        }
    </style>

</head>
<body>
<h2 align="center" style="color: #8d2c31;">For the Flatbread we have</h2>
<div> <section id="demon"style="padding-top: 30px;padding-bottom: 30px">

        <div class="product_list">
            <?php foreach ($product as $product): ?>
                <figure data=<?= $product->Product_ID?> style="width:460px">
                    <img src="../<?= $product->Product_Image?>" alt="<?= $product->Product_Name?>" />
                    <figcaption>
                        <h4 style="text-align: left;font-family: 'Times New Roman';color:  #8d2c31;"><?= $product->Product_Name?>——$<?= $product->Product_Price?>/Package
                        </h4>
                        <button class="button"> <?= $this->Form->postLink(__('Add to Cart'), ['controller'=>'Carts','action' => 'addflatbread', $product->Product_ID]) ?></button>


                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
        <div class="button" style="float:right;margin-top: 50px;margin-bottom: 20px">
            <?=  $this->Html->link("Order it now",['controller'=>'Carts','action'=>'index']) ?>
        </div>
    </section>
</div>

<footer class = "footer">
    <div class="top-nav-title">

        <!-- <?=  $this->Html->link("Cracker",['controller'=>'Orders','action'=>'index']) ?>-->
        <?=  $this->Html->link("Cracker",['controller'=>'Product','action'=>'Cracker']) ?>
    </div>
    <div class="top-nav-title">
        <?=  $this->Html->link("Flatbread",['controller'=>'Product','action'=>'flatbread']) ?>
    </div>
    <div class="top-nav-title">
        <?=  $this->Html->link("Hamper",['controller'=>'Product','action'=>'hamper']) ?>
    </div>

    <div class="top-nav-title">
        <?=  $this->Html->link("Contact us",['controller'=>'Staff','action'=>'add']) ?>
    </div>
</footer>

<style>
    .product_list{
        display:flex;
        flex-wrap: wrap;
    }
    .footer{
        margin-top:100px ;
        background-color: #cccbcb;
        font-size: 15px;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        padding-left: 10px;
        padding-right: 10px;
        color: black;
        font-family: Arial;
        margin-bottom: 20px;

    }
</style>
</body>
