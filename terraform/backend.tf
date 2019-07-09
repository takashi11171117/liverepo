terraform {
    backend "s3" {
        bucket = "terraform-state-234567"
        key = "terraform/liverepo"
    }
}
