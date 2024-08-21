# Sử dụng Nginx làm base image
FROM nginx

# Cài đặt Node.js phiên bản 22.4
RUN apt-get update && \
    apt-get install -y curl && \
    curl -sL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs

# Chạy lệnh để kiểm tra phiên bản Node.js và npm đã cài đặt thành công hay chưa
RUN node -v
RUN npm -v

# # Copy tệp cấu hình Nginx vào container
COPY nginx/nginx.conf /etc/nginx/nginx.conf

# # Cấu hình Nginx và mở cổng 3335
EXPOSE 3335
EXPOSE 3337

# # CMD chạy Nginx khi container được khởi động
CMD ["nginx", "-g", "daemon off;"]


