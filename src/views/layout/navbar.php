<?php

require_once dirname(dirname(__DIR__)) . '/helpers/languages.php';
$class_names = 'class="hover:text-green-500 transition-colors duration-300"';
?>

<div class="bg-white border border-gray-200 shadow">
    <div class="flex justify-between items-center px-5">
        <div>
            <a href="/" class="text-2xl font-bold text-gray-800 py-3"><?= __('website_title') ?></a>
        </div>
        <ul class="flex justify-center items-center gap-5 py-5">
            <li>
                <a href="/" <?= $class_names ?> title="<?= __('home_title') ?>"><?= __('home') ?></a>
            </li>
            <li>
                <a href="/users/register" <?= $class_names ?> title="<?= __('register_title') ?>"><?= __('register') ?></a>
            </li>
            <li>
                <a href="/users/login" <?= $class_names ?> title="<?= __('login_title') ?>"><?= __('login') ?></a>
            </li>
        </ul>
    </div>
</div>