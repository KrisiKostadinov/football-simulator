<?php require dirname(__DIR__) . '/layout/header.php'; ?>
<?php require dirname(__DIR__) . '/layout/navbar.php'; ?>

<?php $input_class_names = 'block w-full rounded-md border border-gray-300 px-4 py-3 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition' ?>
<?php $label_class_names = 'block text-sm font-medium text-gray-700 mb-2' ?>

<main>
    <h1 class="my-5 text-4xl text-center">Вход в профила</h1>

    <p class="mb-6 text-gray-600 text-center max-w-xl mx-auto"><?= __('login_description') ?></p>

    <form action="/users/register" method="POST" class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg grid gap-5">
        <div>
            <label for="email" class="<?= $label_class_names ?>"><?= __('email') ?></label>
            <input type="email" id="email" name="email" required class="<?= $input_class_names ?>" />
        </div>

        <div>
            <label for="password" class="<?= $label_class_names ?>"><?= __('password') ?></label>
            <input type="password" id="password" name="password" required class="<?= $input_class_names ?>" />
        </div>

        <button type="submit" class="outline-none cursor-pointer w-full bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 text-white font-semibold py-3 rounded-md transition-shadow shadow-md hover:shadow-lg focus:shadow-lg">
            <?= __('submit_login') ?>
        </button>
    </form>
</main>

<?php require dirname(__DIR__) . '/layout/footer.php'; ?>
