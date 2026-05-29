<?php include '../config/db.php'; 

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $getSlide = $conn->query("SELECT * FROM sliders WHERE id={$id}");

    $slide = $getSlide->fetch_assoc();
    $imagePath = '../assets/uploads/' . $slide['image'];
    $secondImagePath = '../assets/uploads/' . $slide['second_image'];

    if(file_exists($imagePath)){
        unlink($imagePath);
    }
     if(file_exists($secondImagePath)){
        unlink($secondImagePath);
    }

    $delete = $conn->query("DELETE FROM sliders WHERE id='$id'");
    if($delete){
        echo 'success';
    }else{
        echo 'error';
    }
    exit;

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Slide List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Slide List</h2>
            <a href="../index.php" class="btn btn-primary">
                Add Slide
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tab Name</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Second Image</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slides = $conn->query("SELECT * FROM sliders ORDER BY id DESC");
                    if ($slides->num_rows > 0) {
                        while ($slide = $slides->fetch_assoc()) {
                            $imagePath = '../assets/uploads/' . $slide['image'];
                             $secondImagePath = '../assets/uploads/' . $slide['second_image'];
                    ?>
                            <tr>
                                <td><?= $slide['id'] ?></td>
                                
                                <td><?= $slide['tab_name'] ?></td>
                                <td><?= $slide['title'] ?></td>
                                <td><?= $slide['description'] ?></td>
                                <td>
                                    <img
                                        src="<?= $imagePath ?>"
                                        width="80"
                                        height="60"
                                        style="object-fit: cover;">

                                </td>
                                <td>
                                    <img
                                        src="<?= $secondImagePath ?>"
                                        width="80"
                                        height="60"
                                        style="object-fit: cover;">

                                </td>
                                <td>
                                    <a
                                        href="../index.php?id=<?= $slide['id'] ?>"
                                        class="btn btn-warning btn-sm">

                                        Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-slide" data-id="<?= $slide['id']; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                No slides found
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
    $(document).on('click', '.delete-slide', function() {
    if (confirm('Are you sure?')) {
        let id = $(this).attr('data-id');
        let currentRow = $(this).closest('tr');
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: { id: id },
            success: function(response) {
                console.log(response);
                if (response.trim() == 'success') {
                    console.log('delete')
                    location.reload();
                } else {
                    console.log('Something went wrong');
                }
            },

            error: function(error) {
                console.log('Something went wrong');
                console.log(error);
            }
        });
    }

});

</script>