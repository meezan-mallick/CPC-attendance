<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="m-4">
        <div class="header">
            <div class="heading">
                <h2>Manage Colleges</h2>
            </div>
            <div>

                <a href="colleges/add" class="add-p">
                    <button class="btn btn-primary">Add new</button>
                </a>
            </div>
        </div>
        <hr>
        <div class="table-wrapper data-table">
            <table>
                <thead>

                    <tr>
                        <th>ID</th>
                        <th>College Code</th>
                        <th style="text-align: left;">College Name</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>


                    <?php
                    foreach ($colleges as $college) {
                        echo "<tr>";
                        echo "<td>" . $college['id'] . "</td>";
                        echo "<td>" . $college['college_code'] . "</td>";
                        echo "<td style='text-align:left'>" . $college['college_name'] . "</td>";


                    ?>
                        <td class="text-center">
                            <a class="btn btn-sm btn-warning" href="<?= site_url('colleges/edit/' . $college['id']) ?>">Edit</a> |
                            <a class="btn btn-sm btn-danger" href="<?= site_url('colleges/delete/' . $college['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>


                        </tr>

                    <?php
                    }
                    ?>




                </tbody>
            </table>
        </div>
    </div>

    <?= $this->endSection() ?>