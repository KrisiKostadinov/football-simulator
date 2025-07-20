<?php require dirname(__DIR__) . '/layout/header.php'; ?>
<?php require dirname(__DIR__) . '/layout/navbar.php'; ?>

<?php $input_class_names = 'block w-full rounded-md border border-gray-300 px-4 py-3 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition' ?>
<?php $label_class_names = 'block text-sm font-medium text-gray-700 mb-2' ?>

<main>
    <h1 class="my-5 text-4xl text-center">Създаване на профил</h1>
    <p class="mb-6 text-gray-600 text-center max-w-xl mx-auto"><?= __('register_description') ?></p>

    <form action="/users/register" method="POST" class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg grid gap-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if (isset($errors['general'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['general'] ?></p>
            <?php endif; ?>

            <div>
                <label for="first_name" class="<?= $label_class_names ?>"><?= __('first_name') ?></label>
                <input type="text" id="first_name" value="<?= $old['first_name'] ?? '' ?>" name="first_name" class="<?= $input_class_names ?>" />
                <?php if (isset($errors['first_name'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['first_name'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="last_name" class="<?= $label_class_names ?>"><?= __('last_name') ?></label>
                <input type="text" id="last_name" value="<?= $old['last_name'] ?? '' ?>" name="last_name" class="<?= $input_class_names ?>" />
                <?php if (isset($errors['last_name'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['last_name'] ?></p>
                <?php endif; ?>
            </div>

            <div class="md:col-span-2">
                <label for="username" class="<?= $label_class_names ?>"><?= __('username') ?></label>
                <input type="text" id="username" value="<?= $old['username'] ?? '' ?>" name="username" class="<?= $input_class_names ?>" />
                <?php if (isset($errors['username'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['username'] ?></p>
                <?php endif; ?>
            </div>

            <div class="md:col-span-2">
                <label for="team_name" class="<?= $label_class_names ?>"><?= __('team_name') ?></label>
                <input type="text" id="team_name" value="<?= $old['team_name'] ?? '' ?>" name="team_name" class="<?= $input_class_names ?>" />
                <?php if (isset($errors['team_name'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['team_name'] ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <label for="email" class="<?= $label_class_names ?>"><?= __('email') ?></label>
            <input type="email" id="email" value="<?= $old['email'] ?? '' ?>" name="email" class="<?= $input_class_names ?>" />
            <?php if (isset($errors['email'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['email'] ?></p>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="password" class="<?= $label_class_names ?>"><?= __('password') ?></label>
                <input type="password" id="password" value="<?= $old['password'] ?? '' ?>" name="password" class="<?= $input_class_names ?>" />
                <?php if (isset($errors['password'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['password'] ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="password_confirm" class="<?= $label_class_names ?>"><?= __('password_confirm') ?></label>
                <input type="password" id="password_confirm" value="<?= $old['password_confirm'] ?? '' ?>" name="password_confirm" class="<?= $input_class_names ?>" />
                <?php if (isset($errors['password_confirm'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['password_confirm'] ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <button type="submit"
            class="outline-none cursor-pointer w-full bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 text-white font-semibold py-3 rounded-md transition-shadow shadow-md hover:shadow-lg focus:shadow-lg">
            <?= __('submit_register') ?>
        </button>
    </form>
</main>

<?php require dirname(__DIR__) . '/layout/footer.php'; ?>
