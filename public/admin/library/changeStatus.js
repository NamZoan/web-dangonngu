function updateCategoryStatus(categoryId, isChecked) {
    // Gửi Ajax request tới route hoặc endpoint xử lý ở phía server
    $.ajax({
        method: 'POST',
        url: route('admin.category.updateStatus'),
        data: {
            categoryId: categoryId,
            isChecked: isChecked,
            // Các dữ liệu khác cần truyền lên
        },
        success: function (response) {
            // Xử lý phản hồi từ server (nếu cần)
        }
    });
}
