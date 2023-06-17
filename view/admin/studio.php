<?php
define('MENU_TITLE', "Studio");
include "../../header.php";
?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= MENU_TITLE ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Layout</a></div>
                <div class="breadcrumb-item">Default Layout</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Studio</h4>
                </div>
                <?php
                function getDetailStudio($id)
                {
                    global $con;
                    $query = "SELECT * FROM STUDIO WHERE ID = :ID";
                    $parse = oci_parse($con, $query);
                    oci_bind_by_name($parse, ':ID', $_GET['studio']);
                    oci_execute($parse);
                    return oci_fetch_assoc($parse);
                }
                ?>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>proses/<?= !empty($_GET['studio']) ? 'edit' : 'tambah' ?>-studio" method="post">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= !empty($_GET['studio']) ? getDetailStudio($_GET['studio'])['NAMA'] : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control select2" name="kelas" id="kelas">
                                <option value="Reguler" <?= !empty($_GET['studio']) && getDetailStudio($_GET['studio'])['KELAS']  == 'Reguler' ? 'selected' : '' ?>>Reguler</option>
                                <option value="Dolby Atmos" <?= !empty($_GET['studio']) && getDetailStudio($_GET['studio'])['KELAS']  == 'Dolby Atmos' ? 'selected' : '' ?>>Dolby Atmos</option>
                                <option value="IMAX" <?= !empty($_GET['studio']) && getDetailStudio($_GET['studio'])['KELAS']  == 'IMAX' ? 'selected' : '' ?>>IMAX</option>
                                <option value="The Premiere" <?= !empty($_GET['studio']) && getDetailStudio($_GET['studio'])['KELAS']  == 'The Premiere' ? 'selected' : '' ?>>The Premiere</option>
                            </select>
                        </div>
                        <?= !empty($_GET['studio']) ? '<input type="hidden" value="' . getDetailStudio($_GET['studio'])['ID'] . '" name="id" id="id"> ' : '' ?>
                        <button class="btn btn-success" type="submit"><?= !empty($_GET['studio']) ? 'Edit' : 'Tambah' ?></button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>List Studio</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Studio</th>
                                    <th>Kelas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM STUDIO ORDER BY KELAS, NAMA";
                                $parse = oci_parse($con, $query);
                                oci_execute($parse);
                                $no = 1;
                                while ($res = oci_fetch_assoc($parse)) {
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $res['NAMA'] ?></td>
                                        <td><?= $res['KELAS'] ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>admin/studio?studio=<?= $res['ID'] ?>" class="btn btn-warning btn-sm"><i class="far fa-edit"></i></a>
                                            <a href="<?= BASE_URL ?>proses/hapus-studio?id=<?= $res['ID'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                                oci_free_statement($parse);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
include "../../footer.php";
?>