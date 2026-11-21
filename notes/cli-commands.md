# Minikube & `kubectl` CLI Commands

A step-by-step CLI walkthrough for installing Minikube, managing a local cluster, deploying sample apps (`nginx` and `mongo`), and checking resource metrics.

> For a broader Kubernetes reference, see [Kubernetes Commands.md](./Kubernetes%20Commands.md).

## Table of Contents

- [Install Minikube & `kubectl` (macOS)](#install-minikube--kubectl-macos)
- [Start & Verify the Cluster](#start--verify-the-cluster)
- [Reset & Debug Minikube](#reset--debug-minikube)
- [Inspect Cluster Resources](#inspect-cluster-resources)
- [Create & Manage Deployments](#create--manage-deployments)
- [Debugging Pods](#debugging-pods)
- [Working with YAML Manifests](#working-with-yaml-manifests)
- [Metrics (`kubectl top`)](#metrics-kubectl-top)

---

## Install Minikube & `kubectl` (macOS)

```bash
# Update Homebrew
brew update

# Install Minikube and kubectl
brew install minikube kubectl

# (Optional, Intel macOS only) Install HyperKit driver
# Note: Docker Desktop (--driver=docker) is recommended on modern macOS / Apple Silicon
brew install hyperkit

# Verify installations
minikube version
kubectl version --client
```

---

## Start & Verify the Cluster

```bash
# Start Minikube (uses default driver, e.g. docker; use --driver=hyperkit if using HyperKit)
minikube start
# Or explicitly specify a driver:
minikube start --driver=hyperkit

# Check Minikube cluster status
minikube status

# Verify kubectl can communicate with the cluster
kubectl version
kubectl get nodes
```

---

## Reset & Debug Minikube

If the cluster fails to start or gets into a bad state, delete it and restart with verbose logging:

```bash
# Delete the existing Minikube cluster
minikube delete

# Restart with verbose debug output
minikube start --driver=hyperkit --v=7 --alsologtostderr

# Verify cluster health
minikube status
```

---

## Inspect Cluster Resources

```bash
# List nodes, pods, services, deployments, and replicasets
kubectl get nodes
kubectl get pods
kubectl get services
kubectl get deployments
kubectl get replicasets

# Quick overview of common resources at once
kubectl get all
```

---

## Create & Manage Deployments

### Nginx Deployment

```bash
# Create an nginx deployment
kubectl create deployment nginx-depl --image=nginx

# Verify the deployment, replicaset, and pod
kubectl get deployment
kubectl get replicaset
kubectl get pods

# Edit the live deployment configuration in your default editor
kubectl edit deployment nginx-depl
```

### MongoDB Deployment

```bash
# Create a MongoDB deployment
kubectl create deployment mongo-depl --image=mongo

# Find the generated pod name
kubectl get pods

# Inspect pod logs and detailed events
kubectl logs <mongo_pod_name>
kubectl describe pod <mongo_pod_name>
```

### Delete Deployments

```bash
kubectl delete deployment mongo-depl
kubectl delete deployment nginx-depl
```

---

## Debugging Pods

```bash
# View logs for a pod (add -f to stream live logs)
kubectl logs <pod_name>
kubectl logs -f <pod_name>

# Inspect pod status, containers, and recent events
kubectl describe pod <pod_name>

# Open an interactive shell inside a running pod
kubectl exec -it <pod_name> -- /bin/bash
# (use /bin/sh if bash is not installed in the container)
kubectl exec -it <pod_name> -- /bin/sh
```

---

## Working with YAML Manifests

```bash
# Create or edit a manifest file
vim nginx-deployment.yaml

# Apply the manifest to create or update resources
kubectl apply -f nginx-deployment.yaml

# Verify the created resources
kubectl get pods
kubectl get deployments

# Delete all resources defined in the manifest
kubectl delete -f nginx-deployment.yaml
```

---

## Metrics (`kubectl top`)

`kubectl top` displays current CPU and memory usage for cluster nodes and pods. It requires `metrics-server` to be running in the cluster.

```bash
# Enable metrics-server in Minikube (run once)
minikube addons enable metrics-server

# View CPU and memory usage for nodes
kubectl top nodes

# View CPU and memory usage for pods (current namespace or all namespaces)
kubectl top pods
kubectl top pods -A

# View metrics for a specific pod
kubectl top pod <pod_name>
```
