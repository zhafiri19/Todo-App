<?php
$todos = []; // total array yang disiapkan untuk disimpan
//jika file todo.txt untuk membaca data, bila belum ada biarkan saja
if (file_exists('todo.txt')) {
    $file = file_get_contents('todo.txt'); // membaca file todo
    $todos = unserialize($file); // mengubah format serialize menjadi array
}

//jika ditemukan todo yang dikirimkan melalui method post
if (isset($_POST['todo'])) { //mengambil data yang di input pada form
    $data = $_POST['todo'];
    $todos[] = [
        'todo' => $data,
        'status' => 0
    ];
    simpanAnime($todos);
}

if (isset($_GET['status'])) {
    $todos[$_GET['key']]['status'] = $_GET['status'];
    simpanAnime($todos);
}

//hapus list todo
if (isset($_GET['hapus'])) {
    unset($todos[$_GET['key']]);
    simpanAnime($todos);
}

//membuat fungsi
function simpanAnime($todos)
{
    file_put_contents('todo.txt', serialize($todos));
    header('Location:index.php');
}
?>

<h1>Todo App</h1>

<form method="post">
    <label for="">List Tontonan Anime</label>
    <input type="text" name="todo">
    <button type="submit">Simpan</button>
</form>

<ul>
    <?php
    foreach ($todos as $key => $value):  ?>
        <li>
            <input type="checkbox" name="todo" onclick="window.location.href = 'index.php?status=<?php echo ($value['status'] == 1) ? '0' :
                                                                                                        '1'; ?> &key=<?php echo $key; ?>'" <?php if ($value['status'] == 1) echo 'checked' ?>>
            <label>
                <?php
                if ($value['status'] == 1)
                    echo '<del>' . $value['todo'] . '</del>';
                else
                    echo $value['todo'];
                ?>
            </label>
            <a href="index.php?hapus=1&key=<?php echo $key; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus list anime <?php echo $value['todo']; ?> ?' )">Hapus</a>
        </li>
    <?php endforeach; ?>
</ul>