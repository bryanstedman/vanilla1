<?php
/*
* Copyright 2003 - 2005 Mark O'Sullivan
* This file is part of The Lussumo Framework.
* Vanilla is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
* Vanilla is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with Vanilla; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
* The latest source code for Vanilla is available at www.lussumo.com
* Contact Mark O'Sullivan at mark [at] lussumo [dot] com
*
* Description: The PageEnd control renders the very last items on the page.
*/

// Ends the page body
class PageEnd extends Control {
	function PageEnd(&$Context) {
		$this->Name = "PageEnd";
		$this->Control($Context);
	}
	function Render() {
		$this->CallDelegate("PreRender");
		include($this->Context->Configuration["THEME_PATH"]."templates/page_end.php");
		$this->CallDelegate("PostRender");
	}
}
?>