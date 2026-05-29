    <?php

    include 'config/db.php';

    $editData = [];
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $conn->query("SELECT * FROM sliders WHERE id='$id'");
        $editData = $result->fetch_assoc();
    }
    if (isset($_POST) && !empty($_POST)){
        $id = $_POST['id'] ?? '';
        $tab_name = $_POST['tab_name'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $image = '';
        // image upload
        if (isset($_FILES['image']) && $_FILES['image']['name'] != ''){
            $image = time() . '_' . str_replace(' ', '_', $_FILES['image']['name']);
            $tmp_name = $_FILES['image']['tmp_name'];
            move_uploaded_file($tmp_name, 'assets/uploads/' . $image);
        }

        $secondImage = '';
        // image upload
        if (isset($_FILES['second_image']) && $_FILES['second_image']['name'] != ''){
            $secondImage = time() . '_' . str_replace(' ', '_', $_FILES['second_image']['name']);
            $tmp_name = $_FILES['second_image']['tmp_name'];
            move_uploaded_file($tmp_name, 'assets/uploads/' . $secondImage);
        }
        // update table
        if ($id != ''){
            $oldImage = $editData['image'] ?? '';
            if ($image == ''){
                $image = $oldImage;
            }
            $oldImage = $editData['second_image'] ?? '';
            if ($secondImage == ''){
                $secondImage = $oldImage;
            }
            $sql = "UPDATE sliders SET tab_name='$tab_name', title='$title', description='$description',image='$image', second_image='$secondImage'
            WHERE id='$id'";
        } else {
            // insert
            $sql = "INSERT INTO sliders(tab_name, title, description, image, second_image)
            VALUES('$tab_name', '$title', '$description', '$image', '$secondImage')";
        }
        if ($conn->query($sql)){
            echo 'success';
        } else {
            echo 'error';
        }
        exit;
    }

    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>
            <?= isset($_GET['id']) ? 'Edit Slider' : 'Add Slider' ?>
        </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <style>
            .validation-error {

                color: red;
            }
        </style>
        <div class="container mt-5">
            <h2>
                <?= isset($_GET['id']) ? 'Edit Slider' : 'Add Slider' ?>
            </h2>
            <div class="mb-3">
                <label>Tab Name</label>
                <input type="text" name="tab_name" class="form-control input-field"id="tab_name"
                    value="<?= $editData['tab_name'] ?? '' ?>">
                <span id="error_tab_name" class="validation-error" style="display: none;">Tab name is required</span>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control input-field" id="title" value="<?= $editData['title'] ?? '' ?>">

                <span id="error_title" class="validation-error" style="display: none;">Title is required </span>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea  name="description" class="form-control input-field"  id="description"><?= $editData['description'] ?? '' ?></textarea>

                <span id="error_description" class="validation-error"  style="display: none;">Description is required</span>
            </div>

            <div class="mb-3">
                <label>Image</label>
                <input  type="file" name="image" class="form-control input-field" id="image">
                <span id="error_image" class="validation-error" style="display: none;">  Image is required</span>

                <?php if (isset($_GET['id']) && isset($editData['image'])){ ?>
                    <img src="assets/uploads/<?= $editData['image'] ?>"  width="120" class="mt-3">
                <?php } ?>
            </div>

            <div class="mb-3">
                <label>Second Image</label>
                <input  type="file" name="second_image" class="form-control input-field" id="second_image">
                <span id="error_second_image" class="validation-error" style="display: none;">  Image is required</span>

                <?php if (isset($_GET['id']) && isset($editData['second_image'])){ ?>
                    <img src="assets/uploads/<?= $editData['second_image'] ?>"  width="120" class="mt-3">
                <?php } ?>
            </div>

            <button type="submit" id="submit"  class="btn btn-primary"><?= isset($_GET['id']) ? 'Update' : 'Save' ?>
            </button>
        </div>
    </body>

    </html>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        $(document).on('keydown', '.input-field', function(){
            $(this).css("border-color", "#dee2e6");
            $(this).next('.validation-error').hide();
        });

        // on submit
        $(document).on('click', '#submit', function(){
            var tabName = $("#tab_name").val();
            if (tabName == ''){
                $("#error_tab_name").show();
                $("#tab_name").css("border-color", "red");
                return;
            }

            var title = $("#title").val();
            if (title == ''){
                $("#title").css("border-color", "red");
                $("#error_title").show();
                return;
            }

            var description = $("#description").val();
            if (description == ''){
                $("#description").css("border-color", "red");
                $("#error_description").show();
                return;
            }

            <?php if (!isset($_GET['id'])){ ?>
                var image = $("#image")[0].files.length;
                if (image == 0){
                    $("#image").css("border-color", "red");
                    $("#error_image").show();
                    return;
                }
            <?php } ?>

            let formData = new FormData();
            formData.append('id', '<?= $_GET['id'] ?? '' ?>');
            formData.append('tab_name', $('#tab_name').val());
            formData.append('title', $('#title').val());
            formData.append('description', $('#description').val());
            if ($('#image')[0].files.length > 0){
                formData.append(
                    'image',
                    $('#image')[0].files[0]
                );
            }
            if ($('#second_image')[0].files.length > 0){
                formData.append(
                    'second_image',
                    $('#second_image')[0].files[0]
                );
            }
            // aajx call
            $.ajax({

                type: 'POST',
                url: window.location.href,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    if (response.trim() == 'success'){
                        window.location.href = 'admin/show_slide.php';
                    } else {
                        console.log('Something went wrong');
                    }
                },

                error: function(error){
                    console.log('Something went wrong');
                    console.log(error);
                }
            });
        });
    </script>