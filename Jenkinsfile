#!/usr/bin/env groovy

pipeline {
    environment {
        registry = "mkoziol/purpleclouds"
        registryCredential = 'dockerhub'
        dockerPhpImage = ''
        containerName = 'ecorp-php'
    }

    agent any

    stages {
        stage('Get code from SCM') {
            steps{
                checkout(
                    [$class: 'GitSCM', branches: [[name: '*/master']],
                     doGenerateSubmoduleConfigurations: false,
                     extensions: [],
                     submoduleCfg: [],
                     userRemoteConfigs: [[credentialsId: 'ecorp-repository', url: "git@github.com:Skiru/ecorp.git"]]]
                )
            }
        }

        stage('Building image') {
          steps{
            script {
              dockerPhpImage = docker.build(registry + ":" + containerName + "-$BUILD_NUMBER", "-f ./docker/php/Dockerfile .")
            }
          }
        }

        stage('Deploy Image') {
            steps{
                script {
                  docker.withRegistry( '', registryCredential ) {
                    dockerPhpImage.push()
                  }
                }
           }
        }

        stage('Remove Unused docker image') {
          steps{
            sh "docker rmi $registry:$containerName-$BUILD_NUMBER"
            sh "docker image prune -f"
          }
        }

        stage('Build ecorp application') {
            steps{
                sshagent (credentials: ['purple-clouds-server']) {
                    sh 'echo "docker login --username mkoziol --password pamietamhaslo;IMAGE_BUILD_TAG=$containerName-$BUILD_NUMBER; export IMAGE_BUILD_TAG; docker-compose -f /var/www/PurpleClouds/ecorp/docker-compose.yml up -d;" | ssh -o StrictHostKeyChecking=no -l root 77.55.222.35'
                }
            }
        }

    }
}