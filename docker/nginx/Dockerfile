# Use the official Nginx image as the base
FROM nginx:1.21

# Copy the custom Nginx configuration file
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Remove the default Nginx HTML files
RUN rm -rf /usr/share/nginx/html/*
