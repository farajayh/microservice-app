# Microservice Demo
Demo Laravel Microservice App


## Services
* user-service - /user-service
    - Endpoints
        * Post: /api/user

* notification-service - /notification-service

## Instructions
1. Clone repo - git clone https://github.com/farajayh/microservice-app.git

2. switch to project directory - cd microservice-app

3. modifiy /notification-service/.env.example file
    replace the RabbitMQ configuration information with your own cloudamqp configuration information.
    You can create your own free cloudamqp instance here https://www.cloudamqp.com/
    
4. Do the aboe for /user-service/.env.example file

5. In the project root directory run docker compose up