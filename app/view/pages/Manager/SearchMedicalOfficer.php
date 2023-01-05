<?php
/** @var int $total_pages */
/** @var int $current_page */
/** @var string $q */

use App\model\users\MedicalOfficer;
use App\view\components\Loader\Loader;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
echo CardPane::FilterPane($total_pages,$current_page,$q);
echo CardPane::CreateCardPane(true);
/** @var array $data */
echo CardPane::CreateCards($data,MedicalOfficer::class,"getID",['getFullName','getPosition','getNIC','getBranchLocation'],'getProfileImage');
echo CardPane::CloseCardPane();
?>

