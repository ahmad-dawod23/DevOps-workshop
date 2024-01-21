# DevOps-workshop
Personal DevOps workshop that contains a relevent cheat cheet for docker commands and a .Net WebAPI project added to be tested with it. 

Goals:
1) Containarize the app and push the container to a docker hub repo, use the repo to deploy the API on a kubernete cluster with a deployment manifest. Done, WebAPI.yaml manifest file included.

2) Make a repo to spin up a kubernetes cluster on my laptop. Add commands to easily tear it down and also install some things like argo and other services.

3) Make another repo for gitops for argo to use to deploy the app.

4) Hook it all together so when the app is built and the container is pushed the app will be deployed to my laptop kubernetes cluster.