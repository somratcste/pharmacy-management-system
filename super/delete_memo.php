<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("head.php"); 
include("../connection.php");
$memo_no = $_GET['memo_no'];

$statement = $db->prepare("DELETE FROM memo_info WHERE memo_no = ? ");
$statement->execute(array($memo_no));

$statement = $db->prepare("DELETE FROM memo_item WHERE memo_no = ? ");
$statement->execute(array($memo_no));

$statement = $db->prepare("DELETE FROM memo_price WHERE memo_no = ? ");
$statement->execute(array($memo_no));

echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Memo Deleted successfully')
    window.location.href='memo.php';
    </SCRIPT>");
?>