<div class="w-100 h-100 bg-white-0-5 d-flex align-items-start justify-content-center overflow-y-scroll">
    <div class="d-flex flex-column w-100 p-1 gap-1 justify-content-center mb-4">
        <div class="d-flex flex-column bg-white p-2 w-100 h-90 align-items-center border-radius-10" id="Appearance_Setting">
            <div class="d-flex title">Appearance Setting</div>
            <div class="d-flex align-items-center mt-2 flex-column">
                <div class="form-group">
                    <label for="brandName" class="w-30" style="margin-bottom: 0">Brand Name</label>
                    <input id="brandName" style="width: 70%;" class=" form-control border-1" type="text" value="Be Positive"/>
                </div>
                <div class="form-group ">
                    <label for="brandDescription" class="w-30 align-self-baseline" style="margin-bottom: 0">Brand Motive</label>
                    <textarea id="brandDescription" style="width: 70%; height: 100px;" class=" form-control border-1" type="text" value=""></textarea>
                </div>
                <div class="form-group">
                    <label for="brandLogo" class="w-30" style="margin-bottom: 0">Brand Logo</label>
                    <input id="brandLogo" style="width: 70%;" class=" form-control border-1" type="file" value="Be Positive"/>
                </div>
                <div class="form-group">
                    <label for="brandFavicon" class="w-30" style="margin-bottom: 0">Brand Favicon</label>
                    <input id="brandFavicon" style="width: 70%;" class=" form-control border-1" type="file" value="Be Positive"/>
                </div>
                <div class="form-group">
                    <label for="brandColor" class="w-30" style="margin-bottom: 0">Brand Color</label>
                    <input id="brandColor" style="width: 70%;" class=" form-control border-1" type="color" value="#000000"/>
                </div>


            </div>
        </div>
        <div class="d-flex flex-column bg-white align-items-center w-100 p-2 h-90 border-radius-10" id="HomePage_Setting">
            <div class="d-flex align-items-center w-100 justify-content-center justify-content-between">
                <div></div>
                <div class="title">Home Page Setting</div>
                <button class="btn btn-success float-right" id="addBlog" onclick="AddNewBlog()">Add New Blog</button>
            </div>
            <div class="d-flex align-items-center mt-2 gap-1 overflow-y-scroll flex-column">
                <div class="d-flex text-center w-100 border-2 border-radius-10 p-1" id="blog1">
                    <div class="d-flex p-1">
                        <img src="/public/images/blood-cells.jpg" id="blogImage_1" width="250rem" alt="" class="border-radius-2">
                    </div>
                    <div class="d-flex flex-column text-center">
                        <div class="d-flex w-100 bg-dark py-0-5 text-white text-center justify-content-center" id="blogTitle_1">
                            Why Blood Donation is Important?
                        </div>
                        <div class="d-flex w-100 p-1 text-center flex-column align-items-center" id="content">
                            <div class="d-flex" id="blogContent_1">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!
                            </div>
                            <div class="d-flex gap-1 mt-1">
                                <button class="btn btn-success" onclick="EditBlog('1')">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex text-center w-100 border-2 border-radius-10 p-1" id="blog1">
                    <div class="d-flex p-1">
                        <img src="/public/images/blood-cells.jpg" width="250rem" alt="" class="border-radius-2">
                    </div>
                    <div class="d-flex flex-column text-center">
                        <div class="d-flex w-100 bg-dark py-0-5 text-white text-center justify-content-center" id="title">
                            Why Blood Donation is Important?
                        </div>
                        <div class="d-flex w-100 p-1 text-center flex-column align-items-center" id="content">
                            <div class="d-flex">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!
                            </div>
                            <div class="d-flex gap-1 mt-1">
                                <button class="btn btn-success">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex text-center w-100 border-2 border-radius-10 p-1" id="blog1">
                    <div class="d-flex p-1">
                        <img src="/public/images/blood-cells.jpg" width="250rem" alt="" class="border-radius-2">
                    </div>
                    <div class="d-flex flex-column text-center">
                        <div class="d-flex w-100 bg-dark py-0-5 text-white text-center justify-content-center" id="title">
                            Why Blood Donation is Important?
                        </div>
                        <div class="d-flex w-100 p-1 text-center flex-column align-items-center" id="content">
                            <div class="d-flex">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!
                            </div>
                            <div class="d-flex gap-1 mt-1">
                                <button class="btn btn-success">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex text-center w-100 border-2 border-radius-10 p-1" id="blog1">
                    <div class="d-flex p-1">
                        <img src="/public/images/blood-cells.jpg" width="250rem" alt="" class="border-radius-2">
                    </div>
                    <div class="d-flex flex-column text-center">
                        <div class="d-flex w-100 bg-dark py-0-5 text-white text-center justify-content-center" id="title">
                            Why Blood Donation is Important?
                        </div>
                        <div class="d-flex w-100 p-1 text-center flex-column align-items-center" id="content">
                            <div class="d-flex">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!
                            </div>
                            <div class="d-flex gap-1 mt-1">
                                <button class="btn btn-success" onclick="EditBlog('Blog_01')">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>

</div>