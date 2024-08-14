pipeline {
    agent any

    environment {
        DOCKERHUB_CREDENTIALS = credentials('dockerhub-credential') // Substitua pelo ID das suas credenciais do Docker Hub configuradas no Jenkins
        DOCKERHUB_REPO = 'cookiesoftdev/agenda-instituicional' // Substitua pelo seu repositório no Docker Hub
        APP_NAME = 'agenda-instituicional' // Nome da aplicação
        TAG = "${env.BUILD_NUMBER}" // Use o número da build como tag da imagem
    }

    stages {
        stage('Checkout') {
            steps {
                checkout([$class: 'GitSCM',
                          branches: [[name: '*/main']],
                          userRemoteConfigs: [[url: 'https://github.com/cookiesoftdev/symfony-api-project.git']]
                ])
            }
        }

        stage('Install Dependencies') {
            steps {
                // Instala as dependências do Symfony
                sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
            }
        }

        stage('Run Tests') {
            steps {
                // Executa os testes unitários
                sh 'php bin/phpunit'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Constrói a imagem Docker
                    sh "docker build -t ${DOCKERHUB_REPO}:${TAG} ."
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    // Faz login no Docker Hub
                    sh "echo ${DOCKERHUB_CREDENTIALS_PSW} | docker login -u ${DOCKERHUB_CREDENTIALS_USR} --password-stdin"

                    // Faz o push da imagem para o Docker Hub
                    sh "docker push ${DOCKERHUB_REPO}:${TAG}"
                }
            }
        }
    }

    post {
        always {
            // Limpa as imagens Docker usadas durante a build para liberar espaço
            sh "docker rmi ${DOCKERHUB_REPO}:${TAG} || true"
        }

        success {
            echo 'Build, test and push completed successfully!'
        }

        failure {
            echo 'Build or test failed.'
        }
    }
}