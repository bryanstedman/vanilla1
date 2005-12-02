<?php
/*
Extension Name: IP History
Extension Url: http://lussumo.com/docs/
Description: Adds a complete summary of all IP addresses a user has ever had (and who has shared those IP addresses) to their profile. Note: you must have IP logging turned on in order to record and display this data.
Version: 1.0
Author: Mark O'Sullivan
Author Url: http://www.markosullivan.ca/
*/

/*
* Copyright 2003 - 2005 Mark O'Sullivan
* This file is part of Vanilla.
* Vanilla is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
* Vanilla is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with Vanilla; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
* The latest source code for Vanilla is available at www.lussumo.com
* Contact Mark O'Sullivan at mark [at] lussumo [dot] com
*/

if ($Context->SelfUrl == "account.php") {
   
   // Displays a user's IP history (for admins only)
   class IpHistory extends Control {
      var $History;		// The user's IP history data
      
      function IpHistory(&$Context, &$UserManager, $UserID) {
			$this->Name = "IpHistory";
         $this->PostBackAction = ForceIncomingString("PostBackAction", "");
			$this->Control($Context);
         $this->History = false;
         if ($this->Context->Session->User) {
            if ($this->Context->Session->User->Permission("PERMISSION_IP_ADDRESSES_VISIBLE") && $this->PostBackAction == "") $this->History = $UserManager->GetIpHistory($UserID);
         }
      }
      
      function Render() {
         if ($this->History && $this->PostBackAction == "") {
            include($this->Context->Configuration["THEME_PATH"]."templates/account_ip_history.php");
         }
      }
   }

   // Don't reload objects if you don't need to (ie. If another extension has already loaded it)
   if (!@$UserManager) $UserManager = $Context->ObjectFactory->NewContextObject($Context, "UserManager");
   $AccountUserID = ForceIncomingInt("u", $Context->Session->UserID);
   if (!@$AccountUser) $AccountUser = $UserManager->GetUserById($AccountUserID);
  	$Body->AddControl($Context->ObjectFactory->NewContextObject($Context, "IpHistory", $UserManager, $AccountUserID), 50);
}

// Displays the user's ip address next to his/her comment if the viewing user is an administrator
if ($Context->SelfUrl == "comments.php") {
	function CommentGrid_ShowIPAddress(&$CommentGrid) {
      if ($CommentGrid->Context->Session->UserID > 0) {
         if ($CommentGrid->Context->Session->User->Permission("PERMISSION_IP_ADDRESSES_VISIBLE")) {
				$Comment = $CommentGrid->DelegateParameters["Comment"];
				$CommentList = &$CommentGrid->DelegateParameters["CommentList"];
				$CommentList .= "<div class=\"CommentIp\">".$CommentGrid->Context->GetDefinition("CommentPostedFrom")." ".$Comment->RemoteIp."</div>";
			}
		}
	}
	
	$Context->AddToDelegate("CommentGrid",
		"PreCommentOptionsRender",
		"CommentGrid_ShowIPAddress");	
}
?>