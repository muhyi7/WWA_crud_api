<?php
require_once "koneksi.php";

// Inisialisasi koneksi
$koneksi = (new koneksi())->getKoneksi();

if ($koneksi) {
    // Koneksi berhasil, lanjutkan
    if (isset($_GET['function']) && function_exists($_GET['function'])) {
        $_GET['function']();
    } else {
        // Handle the case when 'function' parameter is missing or invalid
        $response = array(
            'status' => 0,
            'message' => 'Invalid function'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

} else {
    // Handle the case when the database connection fails
    $response = array(
        'status' => 0,
        'message' => 'Database connection failed'
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_user()
{
    global $koneksi;
    $query = $koneksi->query("SELECT * FROM user_detail");
    $data = $query->fetchAll(PDO::FETCH_OBJ);

    $response = array(
        'status' => 1,
        'message' => 'Success',
        'data' => $data
    );

    header('Content-Type: application/json');
    echo json_encode($response);
};

function get_user_id()
{
    global $koneksi;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];

        // Gunakan pernyataan bersiap-siap dengan PDO
        $query = $koneksi->prepare("SELECT * FROM user_detail WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_OBJ);

        if (!empty($data)) {
            $response = array(
                'status' => 1,
                'message' => 'Success',
                'data' => $data
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'No Data Found'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Missing ID'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

