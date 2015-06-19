# Host provisionning with Ansible

## Ansible

Deploy apps. Manage systems. Crush complexity. Ansible is a powerful automation tool that you can learn quickly.

http://www.ansible.com/

## Files structure

- /roles/ => contains all ansible roles
- /inventory => contains the host inventory
- /playbook.yml => the ansible book to play

## Commands

Inside hosts directory:

```ansible all -m ping -i ./inventory```

```ansible-playbook -i ./inventory playbook.yml```
