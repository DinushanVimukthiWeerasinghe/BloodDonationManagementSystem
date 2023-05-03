const AddNewBlog = ()=>{
    OpenDialogBox({
        title:'Add New Blog',
        content:` <div class="form-group w-100">
                    <label for="blogTitle" class="w-40">Blog Title</label>
                    <input type="text" class="w-60 form-control" id="blogTitle" placeholder="Enter Blog Title">
                </div>
                <div class="form-group">
                    <label for="blogContent" class="w-40">Blog Content</label>
                    <textarea class="form-control w-60" placeholder="Enter Blog Description" style="height: 200px;" id="blogContent" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="blogImage" class="w-40">Blog Image</label>
                    <input type="file" class="w-60 form-control" id="blogImage" placeholder="Enter Blog Title">
                </div>
                `,
        successBtnText:'Add Blog',
        successBtnAction:()=>{
            const blogTitle = document.getElementById('blogTitle').value;
            const blogContent = document.getElementById('blogContent').value;
            const blogImage = document.getElementById('blogImage').files[0];
            console.log(blogTitle,blogContent,blogImage);
            if(blogTitle && blogContent && blogImage){
                const formData = new FormData();
                formData.append('Blog_Title',blogTitle);
                formData.append('Blog_Content',blogContent);
                formData.append('Blog_Image',blogImage);
                fetch('/blog/add',{
                    method:'POST',
                    body:formData
                })
                .then(res=>res.json())
                .then(data=>{
                    if(data.status){
                        ShowToast({
                            message:'Blog Added Successfully',
                            type:'success'
                        });
                    }else{
                        ShowToast({
                            message:data.message || 'Something Went Wrong',
                            type:'danger'
                        });
                    }
                })
            }else{
                alert('Please Fill All Fields')
            }
        }
    })
}


const EditBlog = (blogId)=>{
    const Title = document.getElementById(`blogTitle_${blogId}`).innerText;
    const Content = document.getElementById(`blogContent_${blogId}`).innerText;
    const BlogImage = document.getElementById(`blogImage_${blogId}`).src;
    OpenDialogBox({
        title:'Edit Blog',
        content:` <div class="form-group w-100">
                    <label for="blogTitle" class="w-40">Blog Title</label>
                    <input type="text" class="w-60 form-control" id="blogTitle" placeholder="Enter Blog Title" value="`+Title+`">
                </div>
                <div class="form-group">
                    <label for="blogContent" class="w-40">Blog Content</label>
                    <textarea class="form-control w-60" placeholder="Enter Blog Description" style="height: 200px;" id="blogContent" rows="3">`+Content+`</textarea>
                </div>
                <div class="form-group">
                    <label for="blogImage" class="w-40">Blog Image</label>
                    <img src="`+BlogImage+`" alt="" width="150rem">
                    <input type="file" class="w-60 form-control" id="blogImage" placeholder="Enter Blog Title">
                </div>
                `,
        successBtnText:'Update Blog',
        successBtnAction:()=>{
            const blogTitle = document.getElementById('blogTitle').value;
            const blogContent = document.getElementById('blogContent').value;
            const blogImage = document.getElementById('blogImage').files[0];
            console.log(blogTitle,blogContent,blogImage);
            if(blogTitle && blogContent && blogImage){
                const formData = new FormData();
                formData.append('Blog_Title',blogTitle);
                formData.append('Blog_Content',blogContent);
                formData.append('Blog_Image',blogImage);
                fetch(`/blog/update/${blogId}`,{
                    method:'POST',
                    body:formData
                })
                .then(res=>res.json())
                .then(data=>{
                    if(data.status){
                        ShowToast({
                            message:'Blog Updated Successfully',
                            type:'success'
                        });
                    }else{
                        ShowToast({
                            message:data.message || 'Something Went Wrong',
                            type:'danger'
                        });
                    }
                })
            }else{
                alert('Please Fill All Fields')
            }
        }

    })
}