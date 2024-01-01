

# Minikube:

	git clone https://gitlab.com/nanuchi/youtube-tutorial-series

	minikube config set memory 2048 

	minikube config set cpus 4 

	minikube start

	minikube delete

	minikube stop


# K8s
installtion of K8s cluster

	sudo apt install vim git -y

	git clone https://github.com/sandervanvugt/cka

	cd cka

	sudo ./setup-container.sh

	sudo ./setup-kubetools.sh

	control node only:

	sudo kubeadm init 

	mkdir -p $HOME/.kube
	sudo cp -i /etc/kubernetes/admin.conf $HOME/.kube/config
	sudo chown $(id -u):$(id -g) $HOME/.kube/config

Alternatively, if you are the root user, you can run:

	export KUBECONFIG=/etc/kubernetes/admin.conf

		
applying calico's yaml file in (control node only):		
	kubectl apply -f https://raw.githubusercontent.com/projectcalico/calico/v3.26.1/manifests/calico.yaml


control node only when the initialastion does not work, you can reset it:

	sudo kubeadm init reset

create tokens for workers to join:
	sudo kubeadm token create --print-join-command
	
	kubectl create deploy -h

Create a deployment named my-dep that runs the nginx image with 3 replicas
	kubectl create deployment myngnx --image=nginx --replicas=3



Create a deployment named my-dep that runs the busybox image
	kubectl create deployment my-dep --image=busybox

Create a deployment with a command
	kubectl create deployment my-dep --image=busybox -- date

Create a deployment named my-dep that runs the nginx image with 3 replicas
	kubectl create deployment my-dep --image=nginx --replicas=3

Create a deployment named my-dep that runs the busybox image and expose port 5701
	kubectl create deployment my-dep --image=busybox --port=5701

Options:
    --allow-missing-template-keys=true:
        If true, ignore any errors in templates when a field or map key is missing in the template. Only applies to
        golang and jsonpath output formats.

    --dry-run='none':
        Must be "none", "server", or "client". If client strategy, only print the object that would be sent, without
        sending it. If server strategy, submit server-side request without persisting the resource.

    --field-manager='kubectl-create':
        Name of the manager used to track field ownership.

    --image=[]:
        Image names to run.

    -o, --output='':
        Output format. One of: (json, yaml, name, go-template, go-template-file, template, templatefile, jsonpath,
        jsonpath-as-json, jsonpath-file).

    --port=-1:
        The port that this container exposes.

    -r, --replicas=1:
        Number of replicas to create. Default is 1.

    --save-config=false:
        If true, the configuration of current object will be saved in its annotation. Otherwise, the annotation will
        be unchanged. This flag is useful when you want to perform kubectl apply on this object in the future.

    --show-managed-fields=false:
        If true, keep the managedFields when printing objects in JSON or YAML format.

    --template='':
        Template string or path to template file to use when -o=go-template, -o=go-template-file. The template format
        is golang templates [http://golang.org/pkg/text/template/#pkg-overview].

    --validate='strict':
        Must be one of: strict (or true), warn, ignore (or false).              "true" or "strict" will use a schema to validate
        the input and fail the request if invalid. It will perform server side validation if ServerSideFieldValidation
        is enabled on the api-server, but will fall back to less reliable client-side validation if not.               "warn" will
        warn about unknown or duplicate fields without blocking the request if server-side field validation is enabled
        on the API server, and behave as "ignore" otherwise.            "false" or "ignore" will not perform any schema
        validation, silently dropping any unknown or duplicate fields.

Usage:
	kubectl create deployment NAME --image=image -- [COMMAND] [args...] [options]














Cluster Information:

    Check Kubernetes Version:

    

kubectl version

Display Cluster Information:



    kubectl cluster-info

Managing Resources:

    Create a Resource from File:

    

kubectl apply -f <filename.yaml>

Delete a Resource:



kubectl delete <resource_type> <resource_name>

Get Resources:



kubectl get <resource_type>

Describe a Resource:



    kubectl describe <resource_type> <resource_name>

Pods:

    List Pods:

    

kubectl get pods

Get Pod Logs:



kubectl logs <pod_name>

Execute Command in Pod:



    kubectl exec -it <pod_name> -- <command>

Deployments:

    List Deployments:

    

kubectl get deployments

Scale Deployment:



    kubectl scale deployment <deployment_name> --replicas=<replica_count>

Services:

    List Services:

    

kubectl get services

Expose a Deployment as a Service:



    kubectl expose deployment <deployment_name> --type=NodePort --port=<port>

Configuration:

    Edit Configuration:

    

kubectl edit <resource_type> <resource_name>

View Config Maps:



    kubectl get configmaps

Namespaces:

    List Namespaces:

    

kubectl get namespaces

Switch Namespace:



    kubectl config set-context --current --namespace=<namespace>

Contexts and Configuration:

    List Contexts:

    

kubectl config get-contexts

Switch Context:



kubectl config use-context <context_name>

View Kubeconfig Information:



    kubectl config view

Health Checks:

    Check Cluster Nodes:

    

kubectl get nodes

View Pod Health:



kubectl get pods --field-selector=status.phase=Running

Check Events:



    kubectl get events

Debugging:

    Debugging Pods with Shell:

    

kubectl debug <pod_name> -it --image=busybox -- sh

Port Forwarding:



kubectl port-forward <pod_name> <local_port>:<pod_port>