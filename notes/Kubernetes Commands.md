# Kubernetes Cheat Sheet

A quick reference for Minikube, `kubeadm` cluster setup, and day-to-day `kubectl` commands.

## Table of Contents

- [Quick Tips & Shortcuts](#quick-tips--shortcuts)
- [Minikube](#minikube)
- [Cluster Setup (`kubeadm`)](#cluster-setup-kubeadm)
- [Cluster Information & Health](#cluster-information--health)
- [Contexts & Namespaces](#contexts--namespaces)
- [Managing Resources](#managing-resources)
- [Pods](#pods)
- [Deployments & Rollouts](#deployments--rollouts)
- [Services & Networking](#services--networking)
- [ConfigMaps & Secrets](#configmaps--secrets)
- [Debugging & Troubleshooting](#debugging--troubleshooting)

---

## Quick Tips & Shortcuts

```bash
# Enable kubectl alias and bash autocompletion
alias k=kubectl
source <(kubectl completion bash)
complete -o default -F __start_kubectl k
```

### Common Resource Shortnames

| Resource | Shortname |
| :--- | :--- |
| `pods` | `po` |
| `deployments` | `deploy` |
| `services` | `svc` |
| `namespaces` | `ns` |
| `nodes` | `no` |
| `configmaps` | `cm` |
| `secrets` | `secret` |
| `ingress` | `ing` |
| `persistentvolumes` | `pv` |
| `persistentvolumeclaims` | `pvc` |
| `events` | `ev` |

### Useful Global Flags

| Flag | Description |
| :--- | :--- |
| `-n <namespace>` | Target a specific namespace |
| `-A` / `--all-namespaces` | List resources across all namespaces |
| `-o wide` | Show additional details (IPs, nodes, etc.) |
| `-o yaml` / `-o json` | Output full resource definition |
| `-w` / `--watch` | Watch for live changes |
| `-l <key>=<value>` | Filter resources by label |
| `--dry-run=client -o yaml` | Preview/generate YAML without creating the resource |

---

## Minikube

```bash
# Clone tutorial demo repo
git clone https://gitlab.com/nanuchi/youtube-tutorial-series
cd youtube-tutorial-series/demo-kubernetes-components

# Configure resources
minikube config set memory 2048
minikube config set cpus 4

# Cluster lifecycle
minikube start
minikube status
minikube stop
minikube delete

# Get URL for a service
minikube service <service_name> --url

# Open Kubernetes dashboard
minikube dashboard
```

### SSH Port Forwarding to a Minikube Service (Optional)

```bash
# Find existing SSH tunnel processes
ps -ef | grep <user>@127.0.0.1

# Forward local port 8090 to a NodePort service on Minikube
ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no \
  -N <user>@127.0.0.1 -p 22 \
  -i ~/.minikube/machines/minikube/id_rsa \
  -L 8090:<minikube_ip>:<node_port>
```

---

## Cluster Setup (`kubeadm`)

### 1. Prerequisites (All Nodes)

```bash
sudo apt update && sudo apt install -y vim git
git clone https://github.com/sandervanvugt/cka
cd cka

sudo ./setup-container.sh
sudo ./setup-kubetools.sh
```

### 2. Initialize Control Plane (Control Node Only)

```bash
sudo kubeadm init

# Configure kubectl for your regular user
mkdir -p $HOME/.kube
sudo cp -i /etc/kubernetes/admin.conf $HOME/.kube/config
sudo chown $(id -u):$(id -g) $HOME/.kube/config

# Alternatively, if running as root:
export KUBECONFIG=/etc/kubernetes/admin.conf
```

### 3. Install Pod Network Add-on (Control Node Only)

```bash
# Apply Calico CNI manifest
kubectl apply -f https://raw.githubusercontent.com/projectcalico/calico/v3.26.1/manifests/calico.yaml
```

### 4. Join Worker Nodes & Reset

```bash
# Generate a join command with token (run on control node)
sudo kubeadm token create --print-join-command

# Reset a failed initialization or tear down a node
sudo kubeadm reset
```

---

## Cluster Information & Health

```bash
# Check client and server Kubernetes version
kubectl version

# Display cluster endpoint and core services info
kubectl cluster-info

# List cluster nodes and their status
kubectl get nodes -o wide

# View resource usage (requires metrics-server)
kubectl top nodes
kubectl top pods -A

# View cluster events sorted by timestamp
kubectl get events --sort-by='.lastTimestamp'

# View running pods only
kubectl get pods --field-selector=status.phase=Running
```

---

## Contexts & Namespaces

```bash
# List all contexts
kubectl config get-contexts

# Switch active context
kubectl config use-context <context_name>

# View merged kubeconfig settings
kubectl config view

# List all namespaces
kubectl get namespaces

# Create a namespace
kubectl create namespace <namespace>

# Set default namespace for the current context
kubectl config set-context --current --namespace=<namespace>
```

---

## Managing Resources

```bash
# Create or update resources from a YAML/JSON manifest
kubectl apply -f <filename.yaml>

# Delete resources defined in a manifest
kubectl delete -f <filename.yaml>

# Delete a specific resource
kubectl delete <resource_type> <resource_name>

# List resources
kubectl get <resource_type>

# Inspect detailed state and events for a resource
kubectl describe <resource_type> <resource_name>

# Edit a live resource in your default editor
kubectl edit <resource_type> <resource_name>

# View documentation for a resource field
kubectl explain pod.spec.containers
```

---

## Pods

```bash
# List pods (add -o wide for IP/node, -A for all namespaces)
kubectl get pods
kubectl get pods -o wide

# Run a quick standalone pod
kubectl run nginx --image=nginx --port=80

# Generate a pod YAML manifest without creating it
kubectl run nginx --image=nginx --dry-run=client -o yaml > pod.yaml

# View pod logs
kubectl logs <pod_name>
kubectl logs -f <pod_name>                  # Follow/stream logs
kubectl logs <pod_name> -c <container_name> # Specific container in multi-container pod
kubectl logs <pod_name> --previous          # Logs from previous crashed instance

# Open an interactive shell inside a running pod
kubectl exec -it <pod_name> -- /bin/sh

# Copy files between local machine and pod
kubectl cp <local_path> <pod_name>:<container_path>
kubectl cp <pod_name>:<container_path> <local_path>
```

---

## Deployments & Rollouts

### Creating Deployments

```bash
# View help and all flags for deployment creation
kubectl create deployment -h

# Create a deployment with 3 replicas
kubectl create deployment my-dep --image=nginx --replicas=3

# Create a deployment exposing a port
kubectl create deployment my-dep --image=busybox --port=5701

# Create a deployment with a custom command
kubectl create deployment my-dep --image=busybox -- date

# Generate a deployment YAML manifest without applying it
kubectl create deployment my-dep --image=nginx --replicas=3 --dry-run=client -o yaml > deployment.yaml
```

### Scaling & Managing Rollouts

```bash
# List deployments
kubectl get deployments

# Scale a deployment
kubectl scale deployment <deployment_name> --replicas=<replica_count>

# Update container image
kubectl set image deployment/<deployment_name> <container_name>=<new_image>

# Check rollout status and history
kubectl rollout status deployment/<deployment_name>
kubectl rollout history deployment/<deployment_name>

# Roll back to the previous revision
kubectl rollout undo deployment/<deployment_name>

# Restart all pods in a deployment
kubectl rollout restart deployment/<deployment_name>
```

---

## Services & Networking

```bash
# List services and endpoints
kubectl get services
kubectl get endpoints

# Expose a deployment as a NodePort service
kubectl expose deployment <deployment_name> --type=NodePort --port=<port>

# Expose a deployment internally (ClusterIP)
kubectl expose deployment <deployment_name> --port=<port> --target-port=<container_port>

# Forward a local port to a pod or service
kubectl port-forward pod/<pod_name> <local_port>:<pod_port>
kubectl port-forward svc/<service_name> <local_port>:<service_port>
```

---

## ConfigMaps & Secrets

```bash
# List ConfigMaps and Secrets
kubectl get configmaps
kubectl get secrets

# Create a ConfigMap from literals or a file
kubectl create configmap <name> --from-literal=KEY=VALUE
kubectl create configmap <name> --from-file=<path_to_file>

# Create a generic Secret
kubectl create secret generic <name> --from-literal=USERNAME=admin --from-literal=PASSWORD=secret
```

---

## Debugging & Troubleshooting

```bash
# Attach an ephemeral debug container to a running pod
kubectl debug -it <pod_name> --image=busybox -- sh

# Run a temporary pod for network/DNS testing (auto-deleted on exit)
kubectl run tmp-shell --rm -it --image=busybox -- sh

# Inspect pod status, conditions, and recent events
kubectl describe pod <pod_name>

# Drain and uncordon a node for maintenance
kubectl cordon <node_name>
kubectl drain <node_name> --ignore-daemonsets --delete-emptydir-data
kubectl uncordon <node_name>
```
