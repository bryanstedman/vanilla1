<?php
// Note: This file is included from the library/Vanilla.Control.PreferencesForm.php class.
if ($this->Context->Session->UserID != $this->User->UserID && !$this->Context->Session->User->Permission('PERMISSION_EDIT_USERS')) {
   $this->Context->WarningCollector->Add($this->Context->GetDefinition('PermissionError'));
   echo('<div id="Form" class="Account Preferences">
      '.$this->Get_Warnings().'"
   </div>');				
} else {
   echo('<div id="Form" class="Account Preferences">
      <fieldset>
         <legend>'.$this->Context->GetDefinition('ForumFunctionality').'</legend>
         <form name="frmFunctionality" method="post" action="">
         <p class="Description">'.$this->Context->GetDefinition('ForumFunctionalityNotes').'</p>');
         $FirstSection = "";
         while (list($SectionLanguageCode, $SectionPreferences) = each($this->Preferences)) {
            echo('<h2>'.$this->Context->GetDefinition($SectionLanguageCode).'</h2>
               <ul>');
               $SectionPreferencesCount = count($SectionPreferences);
               for ($i = 0; $i < $SectionPreferencesCount; $i++) {
                  $Preference = $SectionPreferences[$i];
                  $PreferenceDefault = ForceBool(@$this->Context->Configuration['PREFERENCE_'.$Preference['Name']], 0);
                  echo '<li>
                     <p>
                        <span>'.GetDynamicCheckBox($Preference['Name'], $PreferenceDefault, $this->Context->Session->User->Preference($Preference['Name']), "PanelSwitch('".$Preference['Name']."', ".ForceBool($Preference['RefreshPageAfterSetting'], 0).");", $this->Context->GetDefinition($Preference['LanguageCode'])).'</span>
                     </p>
                  </li>';									
               }
               
            echo '</ul>';
         }
         echo '</form>
      </fieldset>
   </div>';
}
?>