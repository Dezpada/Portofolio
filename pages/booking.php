<?php
include '../connection/connection.php';

$id_book = "";
$id_renter = "";
$id_fac = "";
$id_det = "";
$date_book = "";
$date_rent = "";
$duration = "";
$total = "";

if (isset($_GET['action'])) {
  $action = $_GET['action'];
} else {
  $action = "";
}

if (isset($_POST['insert'])) {
  $id_book = $_POST['inputBookID'];
  $id_renter = $_POST['inputRentID'];
  $id_fac = $_POST['inputFacID'];
  $id_det = $_POST['inputDetID'];
  $date_book = $_POST['inputBookDate'];
  $date_rent = $_POST['inputRentDate'];
  $duration = $_POST['inputDuration'];
  $total = $_POST['inputTotal'];
  $query = "CALL Create_Pesan('$id_det','$id_fac','$id_renter','$id_book','$duration','$date_book','$date_rent','$total');";
  $result = mysqli_query($conn, $query);
  if ($result) {
    header("Location: booking.php");
  } else {
    echo "Gagal menambah data";
  }
  header("Refresh:0; url=booking.php");
}

if (isset($_POST['update'])) {
  $id_book = $_POST['inputBookID'];
  $id_renter = $_POST['inputRentID'];
  $id_fac = $_POST['inputFacID'];
  $id_det = $_POST['inputDetID'];
  $date_book = $_POST['inputBookDate'];
  $date_rent = $_POST['inputRentDate'];
  $duration = $_POST['inputDuration'];
  $total = $_POST['inputTotal'];
  $query = "UPDATE pemesanan SET ID_PENYEWA='$id_renter',ID_FASILITAS='$id_fac',ID_DET_TAMBAHAN='$id_det',TANGGAL_PESAN='$date_book',TANGGAL_SEWA='$date_rent',LAMA_PESAN='$duration',TOTAL_HARGA='$total' WHERE ID_PESAN='$id_book'";
  $result = mysqli_query($conn, $query);
  if ($result) {
    header("Location: booking.php");
  } else {
    echo "Gagal menambah data";
  }
  header("Refresh:0; url=booking.php");
}

if ($action == "update") {
  $id_book = $_GET['id'];
  $query = "SELECT * FROM pemesanan WHERE ID_PESAN = '$id_book'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $id_book = $row['ID_PESAN'];
  $id_renter = $row['ID_PENYEWA'];
  $id_fac = $row['ID_FASILITAS'];
  $id_det = $row['ID_DET_TAMBAHAN'];
  $date_book = $row['TANGGAL_PESAN'];
  $date_rent = $row['TANGGAL_SEWA'];
  $duration = $row['LAMA_PESAN'];
  $total = $row['TOTAL_HARGA'];
}

if ($action == "delete") {
  $id_book = $_GET['id'];
  $query = "CALL Delete_Pesan('$id_book')";
  $result = mysqli_query($conn, $query);
  if ($result) {
    header("Location: booking.php");
  } else {
    echo "Gagal menghapus data";
  }
  header("Refresh:0; url=booking.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Booking</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="container-scroller">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="account.php"><img src="../assets/images/logo.svg" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="account.php"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
      </div>
      <ul class="nav">
        <li class="nav-item profile">
          <div class="profile-desc">
            <div class="profile-pic">
              <div class="count-indicator">
                <img class="img-xs rounded-circle " src="../assets/images/faces/face15.jpg" alt="">
                <span class="count bg-success"></span>
              </div>
              <div class="profile-name">
                <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                <span>Administrator</span>
              </div>
            </div>
            <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
            <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-onepassword  text-info"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a href="../index.php" class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-logout  text-info"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject ellipsis mb-1 text-small">Log Out</p>
                </div>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item nav-category">
          <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="../pages/account.php">
            <span class="menu-icon">
              <i class="mdi mdi-account"></i>
            </span>
            <span class="menu-title">Account</span>
          </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="../pages/renter.php">
            <span class="menu-icon">
              <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Renter</span>
          </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="../pages/payment.php">
            <span class="menu-icon">
              <i class="mdi mdi-cash-multiple"></i>
            </span>
            <span class="menu-title">Payment</span>
          </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="../pages/booking.php">
            <span class="menu-icon">
              <i class="mdi mdi-book"></i>
            </span>
            <span class="menu-title">Booking</span>
          </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="../pages/camera.php">
            <span class="menu-icon">
              <i class="mdi mdi-camera"></i>
            </span>
            <span class="menu-title">Camera</span>
          </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="../pages/lenses.php">
            <span class="menu-icon">
              <i class="mdi mdi-camera-iris"></i>
            </span>
            <span class="menu-title">Lenses</span>
          </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link" href="../pages/facility.php">
            <span class="menu-icon">
              <i class="mdi mdi-camera-enhance"></i>
            </span>
            <span class="menu-title">Facility</span>
          </a>
        </li>
      </ul>
    </nav>
    <div class="container-fluid page-body-wrapper">
      <nav class="navbar p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="../pages/account.php"><img src="../assets/images/logo.svg" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="../pages/account.php"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
          </button>
        </div>
      </nav>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Booking</h4>
                  <p class="card-description"> For Insert, Edit, or Delete </p>
                  <form class="forms-sample" method="POST">
                    <div class="form-group row">
                      <label for="inputBookID" class="col-sm-3 col-form-label">Booking ID</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputBookID" name="inputBookID" placeholder="Booking ID" value="<?php echo $id_book ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputDetID" class="col-sm-3 col-form-label">Items</label>
                      <div class="col-sm-9">
                        <select onchange="load_data()" id="inputDetID" name="inputDetID" class="form-control" id="floatingSelect" aria-label="Floating label select example">
                          <option value="<?PHP echo $id_det ?>">Pilih Barang</option>
                          <?php
                          $sql = "SELECT detail_tambahan.ID_DET_TAMBAHAN, kamera.NAMA_KAMERA, lensa.NAMA_LENSA FROM kamera INNER JOIN detail_tambahan ON kamera.ID_KAMERA = detail_tambahan.ID_KAMERA INNER JOIN lensa ON detail_tambahan.ID_LENSA = lensa.ID_LENSA";
                          $result = mysqli_query($conn, $sql);
                          while ($row = mysqli_fetch_row($result)) { ?>
                            <option value="<?php echo $row[0] ?>"><?php echo $row[1] ?> & <?php echo $row[2] ?></option>
                          <?php }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputDetPrice" class="col-sm-3 col-form-label">Item(s) Price</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="inputDetPrice" name="inputDetPrice" placeholder="Item(s) Price" value="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputFacID" class="col-sm-3 col-form-label">Facility ID</label>
                      <div class="col-sm-9">
                        <select onchange="load_data2()" id="inputFacID" name="inputFacID" class="form-control" id="floatingSelect" aria-label="Floating label select example">
                          <option value="<?PHP echo $id_fac ?>">Pilih Fasilitas</option>
                          <?php
                          $sql = "SELECT * FROM fasilitas";
                          $result = mysqli_query($conn, $sql);
                          while ($row = mysqli_fetch_row($result)) { ?>
                            <option value="<?php echo $row[0] ?>"><?php echo $row[1] ?> </option>
                          <?php }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputFacPrice" class="col-sm-3 col-form-label">Facility Price</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="inputFacPrice" name="inputFacPrice" placeholder="Facility Price" value="">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputRentID" class="col-sm-3 col-form-label">Renter ID</label>
                      <div class="col-sm-9">
                        <select id="inputRentID" name="inputRentID" class="form-control" id="floatingSelect" aria-label="Floating label select example">
                          <option value="<?PHP echo $id_renter ?>">Pilih Penyewa</option>
                          <?php
                          $sql = "SELECT * FROM penyewa";
                          $result = mysqli_query($conn, $sql);
                          while ($row = mysqli_fetch_row($result)) { ?>
                            <option value="<?php echo $row[0] ?>"><?php echo $row[1] ?> - <?php echo $row[2] ?> </option>
                          <?php }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputBookDate" class="col-sm-3 col-form-label">Booking Date</label>
                      <div class="col-sm-9">
                        <input type="date" class="form-control" id="inputBookDate" name="inputBookDate" placeholder="Booking Date" value="<?php echo $date_book ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputRentDate" class="col-sm-3 col-form-label">Rent Date</label>
                      <div class="col-sm-9">
                        <input type="date" class="form-control" id="inputRentDate" name="inputRentDate" placeholder="Rent Date" value="<?php echo $date_rent ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputDuration" class="col-sm-3 col-form-label">Duration</label>
                      <div class="col-sm-9">
                        <input onkeyup=myFunction() type="number" class="form-control" id="inputDuration" name="inputDuration" placeholder="Duration" value="<?php echo $duration ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputTotal" class="col-sm-3 col-form-label">Total</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="inputTotal" name="inputTotal" placeholder="Total" value="<?php echo $total ?>">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-4 mt-4" name="insert">Insert</button>
                    <button type="submit" class="btn btn-primary mr-4 mt-4" name="update">Update</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Booking Table</h4>
                  <p class="card-description"> For checking any booking
                  </p>
                  <div class="table-responsive">
                    <table id="table_id" class="table table-hover">
                      <thead>
                        <tr>
                          <th>Book ID</th>
                          <th>Renter ID</th>
                          <th>Facility ID</th>
                          <th>Item ID</th>
                          <th>Book Date</th>
                          <th>Rent Date</th>
                          <th>Duration (d)</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?PHP
                        $query = "SELECT * FROM pemesanan";
                        $result = mysqli_query($conn, $query);
                        while ($row_select = mysqli_fetch_assoc($result)) {
                          echo "<tr>";
                          echo "<td>" . $row_select['ID_PESAN'] . "</td>";
                          echo "<td>" . $row_select['ID_PENYEWA'] . "</td>";
                          echo "<td>" . $row_select['ID_FASILITAS'] . "</td>";
                          echo "<td>" . $row_select['ID_DET_TAMBAHAN'] . "</td>";
                          echo "<td>" . $row_select['TANGGAL_PESAN'] . "</td>";
                          echo "<td>" . $row_select['TANGGAL_SEWA'] . "</td>";
                          echo "<td>" . $row_select['LAMA_PESAN'] . "</td>";
                          echo "<td>" . $row_select['TOTAL_HARGA'] . "</td>";
                          echo "<td>";
                          echo "<a href='booking.php?action=update&id=" . $row_select['ID_PESAN'] . "' class='btn btn-primary m-1 btn-edit'><i class='mdi mdi-pencil'></i></a>";
                          echo "<a href='booking.php?action=delete&id=" . $row_select['ID_PESAN'] . "' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ?\")' class='btn btn-danger m-1'><i class='mdi mdi-delete'></i></a>";
                          echo "</td>";
                          echo "</tr>";
                        }
                        ?>

                        <?PHP

                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Daniel Nugroho Simanjuntak 2022</span>
          </div>
        </footer>
      </div>
    </div>
  </div>
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/misc.js"></script>
  <script src="../assets/js/settings.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
  <script type="text/javascript">
    var load_data = function() {
      var id = $('#inputDetID').val();
      $.ajax({
        url: 'display_harga.php',
        type: 'POST',
        data: {
          inputDetPrice: id
        },
        dataType: 'html',
        success: function(response) {
          $('#inputDetPrice').val(response);
        }
      });
    };
    var load_data2 = function() {
      var id2 = $('#inputFacID').val();
      $.ajax({
        url: 'display_harga.php',
        type: 'POST',
        data: {
          inputFacPrice: id2
        },
        dataType: 'html',
        success: function(response) {
          $('#inputFacPrice').val(response);
        }
      });
    };
  </script>
  <script>
    $(document).ready(function() {
      $('#table_id').DataTable();
    });
  </script>
  <script type="text/javascript">
    function myFunction() {
      var harga1 = $('#inputDetPrice').val();
      var harga2 = $('#inputFacPrice').val();
      var durasi = $('#inputDuration').val();
      var total_bayar1 = parseInt (harga1) + parseInt(harga2);
      var total_bayar2 = parseInt (total_bayar1 * durasi);
      $('#inputTotal').val(total_bayar2);
    }
  </script>
</body>

</html>