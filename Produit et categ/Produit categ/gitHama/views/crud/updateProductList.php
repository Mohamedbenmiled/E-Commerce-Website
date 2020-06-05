<?php
    if(isset($_POST['search'])){
        $search = $_POST['search'];
    }else{
        $search = "";
    }
    if(isset($_POST['idCateg'])){
        $idCateg = $_POST['idCateg'];
        if(isset($_POST['sort'])){
            $sort = $_POST['sort'];
            if(isset($_POST['search'])){
                header("Location: ../products.php?idCateg=$idCateg&search=$search&sort=$sort");
            }else{
                header("Location: ../products.php?idCateg=$idCateg&sort=$sort");
            }
        }else{
            if(isset($_POST['search'])){
                header("Location: ../products.php?idCateg=$idCateg&search=$search");
            }else{
                header("Location: ../products.php?idCateg=$idCateg");
            }
        }
    }else{
        if(isset($_POST['sort'])){
            $sort = $_POST['sort'];
            if(isset($_POST['search'])){
                header("Location: ../products.php?search=$search&sort=$sort");
            }else{
                header("Location: ../products.php?sort=$sort");
            }
        }else{
            if(isset($_POST['search'])){
                header("Location: ../products.php?search=$search");
            }else{
                header("Location: ../products.php");
            }
        }
    }
?>