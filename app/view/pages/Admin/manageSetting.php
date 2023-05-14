<div class="w-100 h-100 d-flex flex-column align-items-center justify-content-start overflow-y-scroll">
    <div class="d-flex w-100 p-1 gap-1 justify-content-center mb-1">
<!--        <div class="d-flex flex-column bg-white p-2 w-100 align-items-center border-radius-10" id="Appearance_Setting">-->
<!--            <div class="d-flex title">Appearance Setting</div>-->
<!--            <div class="d-flex align-items-center mt-2 flex-column">-->
<!--                <div class="form-group">-->
<!--                    <label for="brandName" class="w-30" style="margin-bottom: 0">Brand Name</label>-->
<!--                    <input id="brandName" style="width: 70%;" class=" form-control border-1" type="text" value="Be Positive"/>-->
<!--                </div>-->
<!--                <div class="form-group ">-->
<!--                    <label for="brandDescription" class="w-30 align-self-baseline" style="margin-bottom: 0">Brand Motive</label>-->
<!--                    <textarea id="brandDescription" style="width: 70%; height: 100px;" class=" form-control border-1" type="text" value=""></textarea>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="brandLogo" class="w-30" style="margin-bottom: 0">Brand Logo</label>-->
<!--                    <input id="brandLogo" style="width: 70%;" class=" form-control border-1" type="file" value="Be Positive"/>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="brandFavicon" class="w-30" style="margin-bottom: 0">Brand Favicon</label>-->
<!--                    <input id="brandFavicon" style="width: 70%;" class=" form-control border-1" type="file" value="Be Positive"/>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="brandColor" class="w-30" style="margin-bottom: 0">Brand Color</label>-->
<!--                    <input id="brandColor" style="width: 70%;" class=" form-control border-1" type="color" value="#000000"/>-->
<!--                </div>-->
<!---->
<!---->
<!--            </div>-->
<!--        </div>-->
        <div class="d-flex flex-column bg-white align-items-center w-100 p-2 border-radius-10" id="HomePage_Setting">
<!--            <div class="d-flex align-items-center w-90 border-radius-10 p-2 justify-content-center justify-content-center bg-dark py-1 relative">-->
<!--                <div class="text-2xl">Home Page Blog Setting</div>-->
<!--                <button class="btn btn-success absolute right-1" id="addBlog" onclick="AddNewBlog()">Add New Blog</button>-->
<!--            </div>-->
            <div class="d-flex align-items-center justify-content-center bg-dark text-white text-2xl w-90 border-radius-10 py-1">
                <div class="w-100 text-center">Home Page Blog Setting</div>
                <button class="mr-1 flex-center d-flex flex btn btn-success gap-1" onclick="AddNewBlog()">
                    <i class="fa-solid fa-square-rss fa-2x"></i>
                    Add New Blog
                </button>
            </div>
            <div class="d-flex align-items-center mt-2 gap-1 overflow-y-scroll flex-column overflow-y-overlay" style="max-height: 50vh">
                <?php
                /** @var Blog[] $Blogs */

                use App\model\Blog\Blog;
                use App\model\Utils\Date;

                if (!empty($Blogs)):
                    foreach ($Blogs as $blog):
                ?>
                <div class="d-flex text-center w-100 border-2 border-radius-10 p-1" id="blog1">
                    <div class="d-flex p-1">
                        <img src="<?=$blog->getBlogImage()?>" id="blogImage_<?=$blog->getBlogID()?>" width="250rem" alt="" class="border-radius-2">
                    </div>
                    <div class="d-flex flex-column text-center">
                        <div class="d-flex w-100 bg-dark py-0-5 text-white text-center justify-content-center" id="blogTitle_<?=$blog->getBlogID()?>">
                            <?= $blog->getBlogTitle();?>
                        </div>
                        <div class="d-flex w-100 p-1 text-center flex-column align-items-center" id="content">
                            <div class="d-flex" id="blogContent_<?=$blog->getBlogID()?>">
                                <?= $blog->getBlogContent();?>
                            </div>
                            <div class="d-flex gap-1 mt-1">
                                <button class="btn btn-success d-flex flex-center gap-1" onclick="EditBlog('<?=$blog->getBlogID()?>')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit
                                </button>
                                <button class="btn btn-danger d-flex flex-center gap-1" onclick="DeleteBlog('<?=$blog->getBlogID()?>')">
                                    <i class="fa-solid fa-trash"></i>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                 else:
                ?>
                <div class="d-flex flex-center text-center w-100 border-radius-10 p-2" id="blog1">
                    <div class="d-flex flex-column flex-center text-center box-shadow-danger border-radius-10 p-2">
                        <div class="d-flex flex-column font-bold text-2xl flex-center  w-100 py-0-5 text-center " id="blogTitle_1">
                            <i class="fa-brands fa-blogger fa-4x"></i>
                            No Blog Found
                        </div>
                    </div>
                </div>
                <?php
                 endif;
                ?>



            </div>
        </div>
    </div>
    <div class="d-flex flex-column min-h-40 bg-white p-2 border-radius-10 gap-0-5 align-items-center gap-3 justify-content-start w-95">
        <div class="d-flex align-items-center justify-content-center bg-dark text-white text-2xl w-90 border-radius-10 py-1">
            <div class="w-100 text-center">Database Setting</div>
            <button class="mr-1 flex-center d-flex flex btn btn-success gap-1" onclick="BackupDatabase()">
                <i class="fa-solid fa-2x fa-database"></i>
                Backup Database
            </button>
        </div>
        <div class="d-flex w-90">
            <table>
                <thead class="sticky top-0 border-1 border-dark">
                    <tr>
                        <th> No </th>
                        <th> Backup Name </th>
                        <th> Backup Date </th>
                        <th> Action </th>
                    </tr>
                </thead>

                <tbody>
                <?php
                /** @var \App\model\Utils\Backup[] $Backups */
                if (!empty($Backups)):
                $i=1;
                foreach ($Backups as $backup):
                ?>
                    <tr>
                        <td> <?=$i++?></td>
                        <td> <?=$backup->getBackupName()?> </td>
                        <td><?= Date::GetProperDate($backup->getBackupDate())?> </td>
                        <td>
                            <button class="btn btn-success" onclick="DownloadBackup('<?=$backup->getBackupName()?>')">
                                <i class="fa-solid fa-cloud-arrow-down"></i>
                                Download
                            </button>
                        </td>
                    </tr>
                <?php
                endforeach;
                else:
                ?>
                    <tr>
                        <td colspan="4" class="text-center">No Backup Found</td>
                    </tr>
                <?php
                endif;
                ?>
                </tbody>
            </table>
        </div>

    </div>

</div>