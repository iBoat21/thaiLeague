<?php

include "../config/connect.php";


// index

function getCompetitionData($conn)
{
    $sql = "SELECT * FROM competition";
    return mysqli_query($conn, $sql);
}

function loopCompetitionData($qCompetition)
{
    $rows = mysqli_num_rows($qCompetition);

    for ($i = 0; $i < $rows; $i++) {
        $result = mysqli_fetch_assoc($qCompetition);
        $id = $result['id'];
        $name = $result['name'];
        $slug = $result['slug'];
        $banner = $result['banner'];
        $max_teams = $result['max_teams'];

        if ($rows == 0) {
            echo "<tr>";
            echo "<td colspan='4'> NO Data....</td>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td>$name</td>";
            echo "<td><img src='../images/$banner' alt='$name banner'></td>";
            echo "<td>$max_teams</td>";
            echo "<td><a href='$slug'>More Info</a></td>";
            echo "</tr>";
        }
    }
}

//details

function getDataBySlug($conn, $slug)
{
    $sql = "SELECT * FROM competition WHERE slug = '$slug'";
    return mysqli_query($conn, $sql);
}

function getProvinceFromCompetitionId($conn, $competition_id)
{
    $sql = "SELECT provinces.name_thai, provinces.name_english
                FROM provinces
                INNER JOIN competition_provinces
                ON competition_provinces.province_id = provinces.id
                WHERE competition_provinces.competition_id = $competition_id
        ";
    return mysqli_query($conn, $sql);
}

function queryDataFromSlug($conn, $slug)
{
    $querySlugData = getDataBySlug($conn, $slug);
    if (mysqli_num_rows($querySlugData) == 0) {
        echo "No Data..";
        return;
    }

    $competition = mysqli_fetch_assoc($querySlugData);
    $id = $competition['id'];
    $name = $competition['name'];
    $banner = $competition['banner'];
    $teams = $competition['max_teams'];

    echo "<h2>$name Competition Info</h2>";
    echo "<img src='../images/$banner' alt='$name banner'>";
    echo "<p>Max Teams : $teams</p>";

    $provinceData = getProvinceFromCompetitionId($conn, $id);
    echo "<h2>Allowed Provinces : </h2>";
    echo "<ul>";
    while ($province = mysqli_fetch_assoc($provinceData)) {
        $name_thai = $province['name_thai'];
        $name_english = $province['name_english'];
        echo "<li>$name_thai ($name_english)</li>";
    }
    echo "</ul>";
}

//create competition

function provinceData($conn){
    $sql = "SELECT id, name_thai, name_english FROM provinces";
    $qProvince = mysqli_query($conn, $sql);
    echo "<div id='provinces'>";
    while($province = mysqli_fetch_assoc($qProvince)){
        $id = $province['id'];
        $th_name = $province['name_thai'];
        echo "<label><input type='checkbox' name='provinces[]' values='$id'>$th_name</label>";
    }
    echo "</div>";
}

function generateSlug($string)
{
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-zA-Z0-9]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return rtrim($string, '-');
}

function handleCreation($conn, $postData, $fileData)
{
    $name = $_POST['name'];
    $slug = generateSlug($name);
    $max_teams = $postData['team'];

    // ตรวจสอบไฟล์รูปภาพ
    if ($fileData['banner']['error'] === 4) {
        echo "<script>alert('Image Does Not Exist');</script>";
        return;
    }

    $fileName = $fileData['banner']['name'];
    $fileSize = $fileData['banner']['size'];
    $tmpName = $fileData['banner']['tmp_name'];
    $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $validImageExtension = ['jpg', 'jpeg', 'png'];

    if (!in_array($imageExtension, $validImageExtension) || $fileSize > 10000000) {
        $errorMsg = !in_array($imageExtension, $validImageExtension) ? 'Invalid Image Extension' : 'Image Size Too Large';
        echo "<script>alert('$errorMsg');</script>";
        return;
    }

    $newImageName = uniqid('img-', true) . '.' . $imageExtension;
    move_uploaded_file($tmpName, '../images/' . $newImageName);

    // ตรวจสอบ slug
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM competition WHERE slug='$slug'")) > 0) {
        echo "<script>alert('This Slug Has Been Used');</script>";
        return;
    }

    if (mysqli_query($conn, "INSERT INTO competition (name, slug, banner, max_teams) VALUES ('$name','$slug','$newImageName','$max_teams')")) {
        $max_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(id) AS max_id FROM competition"))['max_id'];

        foreach ($postData['provinces'] as $province_id) {
            mysqli_query($conn, "INSERT INTO competition_provinces (competition_id, province_id) VALUES ('$max_id','$province_id')");
        }

        echo "<script>
                alert('Competition created successfully');
                document.location.href = '../league03/competitions';
            </script>";
    } else {
        echo "<script>alert('Failed to Create Competition');</script>";
    }
}
?>;;