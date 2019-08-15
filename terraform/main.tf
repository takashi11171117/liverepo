provider "digitalocean" {
  token = "${var.token}"
}

resource "digitalocean_droplet" "web" {
  image = "48844600"
  name = "liverepo-demo"
  region = "sgp1"
  size = "1gb"
  ssh_keys = [${var.ssh_key}]
  monitoring = "true"
  private_networking = "true"
}

resource "digitalocean_domain" "liverepo_domain" {
  name       = "liverepo.info"
}

resource "digitalocean_record" "staging_domain" {
    type   = "A"
    domain = "${digitalocean_domain.liverepo_domain.name}"
    name   = "staging"
    value  = "${digitalocean_droplet.web.ipv4_address}"
}

resource "digitalocean_database_cluster" "liverepo_database" {
  name       = "liverepo-cluster"
  engine     = "pg"
  version    = "11"
  size       = "db-s-1vcpu-1gb"
  region     = "sgp1"
  node_count = 1

  maintenance_window {
    day  = "monday"
    hour = "16:00:00"
  }
}