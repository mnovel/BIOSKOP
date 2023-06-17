<?php
define('MENU_TITLE', "Jam Tayang");
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
                    <h4><?= !empty($_GET['jam_tayang']) ? 'Edit' : 'Tambah' ?> Jam Tayang</h4>
                </div>
                <?php
                function getDetailJamTayang($id)
                {
                    global $con;
                    $query = "SELECT * FROM JAM_TAYANG WHERE ID = :ID";
                    $parse = oci_parse($con, $query);
                    oci_bind_by_name($parse, ':ID', $id);
                    oci_execute($parse);
                    $res = oci_fetch_assoc($parse);
                    oci_free_statement($parse);
                    return $res;
                }
                ?>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>proses/<?= !empty($_GET['jam_tayang']) ? 'edit' : 'tambah' ?>-jam-tayang" method="POST">
                        <div class="form-group">
                            <label>Judul Film</label>
                            <select class="form-control select2" name="film" id="film">
                                <?php
                                $query = "SELECT UUID FROM FILM";
                                $parse = oci_parse($con, $query);
                                oci_execute($parse);

                                while ($res = oci_fetch_assoc($parse)) {
                                    $fetch = getDetailFilm($res['UUID']);
                                ?>
                                    <option value="<?= $res['UUID'] ?>" <?= !empty($_GET['jam_tayang']) && getDetailJamTayang((int)$_GET['jam_tayang'])['ID_FILM'] == $res['UUID'] ? 'selected' : '' ?>><?= $fetch->original_title  . ' ( ' . date("Y", strtotime($fetch->release_date)) . ' ) ' ?></option>
                                <?php
                                }
                                oci_free_statement($parse);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Waktu Tayang</label>
                            <input type="text" class="form-control datetimepicker" name="jam" id="jam">
                        </div>
                        <div class="form-group">
                            <label>Studio</label>
                            <select class="form-control select2" name="studio" id="studio">
                                <?php
                                $query = "SELECT * FROM STUDIO ORDER BY KELAS, NAMA";
                                $parse = oci_parse($con, $query);
                                oci_execute($parse);

                                while ($res = oci_fetch_assoc($parse)) {
                                ?>
                                    <option value="<?= $res['ID'] ?>" <?= !empty($_GET['jam_tayang']) && getDetailJamTayang((int)$_GET['jam_tayang'])['ID_STUDIO'] == $res['ID'] ? 'selected' : '' ?>><?= $res['NAMA'] . ' - ' . $res['KELAS']  ?></option>
                                <?php
                                }
                                oci_free_statement($parse);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Harga</label>
                            <input type="text" class="form-control" name="harga" id="harga" value="<?= !empty($_GET['jam_tayang']) ? getDetailJamTayang((int)$_GET['jam_tayang'])['HARGA'] : '' ?>">
                        </div>
                        <?= !empty($_GET['jam_tayang']) ? '<input type="hidden" value="' . getDetailJamTayang((int)$_GET['jam_tayang'])['ID'] . '" name="id" id="id"> ' : '' ?>
                        <?= !empty($_GET['jam_tayang']) ? '<input type="hidden" value="' . (int)$_GET['studio'] . '" name="idStudio" id="idStudio"> ' : '' ?>
                        <button class="btn btn-success" type="submit"><?= !empty($_GET['jam_tayang']) ? 'Edit' : 'Tambah' ?></button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Jadwal Jam Tayang</h4>
                </div>
                <div class="card-body">
                    <div class="form-group mb-5">
                        <select class="form-control select2" name="studio" id="studio" onchange="window.location='?studio='+this.value">
                            <option value="0" selected disabled>Pilih..</option>
                            <?php
                            $query = "SELECT * FROM STUDIO ORDER BY KELAS, NAMA";
                            $parse = oci_parse($con, $query);
                            oci_execute($parse);
                            while ($res = oci_fetch_assoc($parse)) {
                            ?>
                                <option value="<?= $res['ID'] ?>" <?= !empty($_GET['studio']) && $_GET['studio'] == $res['ID'] ? 'selected' : '' ?>><?= $res['NAMA'] . ' - ' . $res['KELAS']  ?></option>
                            <?php
                            }
                            oci_free_statement($parse);
                            ?>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Jam</th>
                                    <th>Judul Film</th>
                                    <th>Studio</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT J.ID, JAM, UUID, S.NAMA, S.KELAS FROM JAM_TAYANG J JOIN FILM F ON F.UUID = J.ID_FILM JOIN STUDIO S ON S.ID = J.ID_STUDIO  WHERE ID_STUDIO = :ID_STUDIO";
                                $parse = oci_parse($con, $query);
                                oci_bind_by_name($parse, ':ID_STUDIO', $_GET['studio']);
                                oci_execute($parse);
                                $no = 1;
                                while ($res = oci_fetch_assoc($parse)) {
                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= date("d F Y H:i:s", strtotime($res['JAM'])) ?> WIB</td>
                                        <td><?= getDetailFilm($res['UUID'])->original_title . ' ( ' . date("Y", strtotime(getDetailFilm($res['UUID'])->release_date))  . ' )' ?></td>
                                        <td><?= $res['NAMA'] . ' - ' . $res['KELAS'] ?></td>
                                        <td>
                                            <a href="?jam_tayang=<?= $res['ID'] ?><?= !empty($_GET['studio']) ? '&studio=' . $_GET['studio'] : '' ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            <a href="<?= BASE_URL ?>proses/hapus-jam-tayang?id=<?= $res['ID'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php $no++;
                                }
                                oci_free_statement($parse);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<?php
include "../../footer.php";
?>