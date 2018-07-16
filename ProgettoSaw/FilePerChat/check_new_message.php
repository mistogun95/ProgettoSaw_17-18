<?php
function check_new_message($user1, $conn)
{
    ini_set('display_errors','On');
    error_reporting(E_ALL); 
    include "take_chat_id.php";

    $Id_chats = take_chat_id($user1, $conn);
    $query = "SELECT Username_Autore FROM mes WHERE ID_Private_Chat=? AND Letto=?";
    $usernames = array();
    $b = FALSE;

    foreach($Id_chats as $Id_chat)
    {
        if(!$stmt = $conn->prepare($query))
        {
            header("Refresh:0; URL=../error.php");
        }
        if(!$stmt->bind_param("ii", $Id_chat, $b))
        {
            $stmt->close();
            header("Refresh:0; URL=../error.php");
        }
        if(!$stmt->execute())
        {
            $stmt->close();
            header("Refresh:0; URL=../error.php");
        }
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
        $usernames[] = $username;
    }
    return $usernames;
}
   
    
?>