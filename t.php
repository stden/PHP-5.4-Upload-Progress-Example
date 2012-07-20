<?php
session_start();
echo session_id().'<br>';
$uploadName = 'test'; // ���������� ���
if (isset($_GET['ajax'])) { // ����������� ������
    if (isset($_SESSION["upload_progress_$uploadName"])) { // ���� ����������� � ������ ������
        $progress = $_SESSION["upload_progress_$uploadName"];
        $percent = round(100 * $progress['bytes_processed'] / $progress['content_length']);
        echo "Upload progress: $percent%<br /><pre>" . print_r($progress, 1) . '</pre>';
    } else {
        echo 'no uploading';
    }
    exit;
} elseif (isset($_GET['frame'])) { // ������� ����� ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=ini_get("session.upload_progress.name")?>"
                value="<?=$uploadName?>" /><br />
        <input type="file" name="file" /><br />
        <input type="submit" />
    </form>
<?php } else { ?>
    <iframe src="?frame" height="200" width="500"></iframe>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>
        $(function() {
            setInterval(function() { // �������� ������������
                $.get('?ajax', function(data) { // � ��������� ��������
                    $('#ajax').html(data); // ��������� �� �� ��������
                });
            }, 500);
        });
    </script>
    <div id="ajax"></div>
<?php }