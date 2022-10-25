<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

    <nav class="top-nav">
        <div class="top-nav-title" >
            <a href="<?= $this->Url->build('/') ?>"><span>JJ</span>Cracker</a>
        </div>
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
            <?=  $this->Html->link("Carts",['controller'=>'Carts','action'=>'index']) ?>
        </div>
        <div class="top-nav-title">
            <?=  $this->Html->link("Contact us",['controller'=>'Staff','action'=>'add']) ?>
        </div>
        <div class="top-nav-title">
        <?php if(isset($username)): ?>
            <?=  $this->Html->link("Logout",['controller'=>'Users','action'=>'logout']) ?>
        <?php else: ?>
            <?=  $this->Html->link("Login",['controller'=>'Users','action'=>'login']) ?>
            &nbsp;
            <?=  $this->Html->link("/ Register",['controller'=>'Users','action'=>'add']) ?>
        <?php endif; ?>
        <span style="font-size:22px;color: #6e0f0f;margin-left:20px;">
            <?php if(isset($username)): ?>
                <?= $username ?>
            <?php endif; ?>
        </span>

    </nav>

    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
