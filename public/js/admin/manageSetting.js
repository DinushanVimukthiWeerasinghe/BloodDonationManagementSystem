const AddNewBlog = ()=>{
    OpenDialogBox({
        title:'Add New Blog',
        titleClass:'text-center bg-dark text-white',
        content:` 
                <div class="d-flex flex-column align-items-center gap-1">
                    <div class="form-group w-100">
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
                </div>
                `,
        successBtnText:'Add Blog',
        successBtnAction:()=>{
            const blogTitle = document.getElementById('blogTitle').value;
            const blogContent = document.getElementById('blogContent').value;
            const blogImage = document.getElementById('blogImage').files[0];

            if (blogContent.length < 200) {
                ShowToast({
                    message:'Blog Content Should Be Atleast 200 Characters',
                    type:'danger'
                });
                return;
            }

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
                    console.log(data)
                    if(data.status){
                        ShowToast({
                            message:'Blog Added Successfully',
                            type:'success'
                        });
                        setTimeout(()=>{
                            location.reload();
                        })
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

const DeleteBlog = (blogId)=>{
    OpenDialogBox({
        title:'Delete Blog',
        content:'Are You Sure You Want To Delete This Blog',
        successBtnText:'Delete Blog',
        successBtnAction:()=>{
            const formData = new FormData();
            formData.append('Blog_ID',blogId);
            fetch(`/blog/delete`,{
                method:'POST',
                body:formData
            })
            .then(res=>res.json())
            .then(data=>{
                if(data.status){
                    ShowToast({
                        message:'Blog Deleted Successfully',
                        type:'success'
                    });
                }else{
                    ShowToast({
                        message:data.message || 'Something Went Wrong',
                        type:'danger'
                    });
                }
            })
        }
    })
}

const BackupDatabase = ()=>{
    OpenDialogBox({
        title:'Backups Database',
        content:'Are You Sure You Want To Backups Database',
        successBtnText:'Backups Database',
        successBtnAction:()=>{
            fetch(`/backup/database`,{
                method:'POST'
            })
            .then(res=>res.json())
            .then(data=>{
                if(data.status){
                    ShowToast({
                        message:'Database Backups Successfully',
                        type:'success'
                    });
                    CloseDialogBox();
                }else{
                    ShowToast({
                        message:data.message || 'Something Went Wrong',
                        type:'danger'
                    });
                }
            })
        }
    })
}

const DownloadBackup = (backupName)=>{
    OpenDialogBox({
        title:'Download Backup',
        content:'Are You Sure You Want To Download This Backup',
        successBtnText:'Download Backup',
        successBtnAction:()=>{
            const formData = new FormData();
            formData.append('Backup_Name',backupName);
            fetch(`/backup/download`,{
                method:'POST',
                body:formData
            })
            .then(res=>res.json())
            .then(data=>{

                console.log(data)
                if(data.status){
                    const file_data = atob(data.data.file_data);
                    const blob = new Blob([file_data], {type: data.data.file_mime});
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = data.data.file_name;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    ShowToast({
                        message:'Backup Downloaded Successfully',
                        type:'success'
                    });
                    CloseDialogBox();
                }else{
                    ShowToast({
                        message:data.message || 'Something Went Wrong',
                        type:'danger'
                    });
                }
            })
        }
    })
}