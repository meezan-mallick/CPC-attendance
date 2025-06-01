<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!-- Page Content -->
<div id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header d-flex justify-content-between align-items-center">
                    <h2>Manage Colleges</h2>
                    <a href="<?= site_url('colleges/add') ?>" class="add-p">
                        <button class="btn btn-primary px-3 py-2">Add New College</button>
                    </a>
                </div>
            </div>
        </div>
        <hr>

        <!-- Colleges List -->
        <div class="row">
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover table-striped table-bordered text-center">
                    <thead class="table-dark">
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
                            echo "<tr >";
                            echo "<td>" .  esc($college['id']) . "</td>";
                            echo "<td>" .  esc($college['college_code']) . "</td>";
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
    </div>
</div>

<?= $this->endSection() ?>