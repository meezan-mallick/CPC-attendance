<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CPC-ORBIT' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <!-- boostrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <!-- if Loggedin Show dashboard -->
    <?php if (session()->get('logged_in')): ?>
        <div>
            <!-- Sidebar for Desktop & Collapsible Menu for Mobile -->
            <div class="sidebar" id="sidebar">
                <?php include 'navbar.php'; ?>
            </div>

            <!-- Main Content (Adjust Width Dynamically) -->

            <main class="content">

                <!-- Header -->
                <div class="search-bar">

                    <div class="serch-input">
                        <input class="search-input" type="text" placeholder="Search " />
                        <img class="search-icon" src="/assets/Images/Icons/search.png" alt="" height="20">
                    </div>

                    <div class="current-user-login">
                        <div>
                            <span class="person-icon"><img src="/assets/Images/Icons/person.svg" alt="" height="35"></span>
                        </div>
                        <div>
                            <p><?= session()->get('full_name') ?></p>
                            <p><?= session()->get('role') ?></p>

                        </div>
                    </div>


                </div>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
        <!-- If no Login Show Login form  -->
    <?php else: ?>
        <?= $this->renderSection('content') ?>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });
    </script>

</body>

</html>