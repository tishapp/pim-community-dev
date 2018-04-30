# UPGRADE FROM 2.3 TO 3.0

## Migrate your custom code

Several classes and services have been moved or renamed. The following commands help to migrate references to them:

```bash
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Entity\\UserManager/Pim\\Bundle\\UserBundle\\Manager\\UserManager/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Type\\RoleApiType/Pim\\Bundle\\UserBundle\\Form\\Type\\RoleApiType/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Type\\AclRoleType/Pim\\Bundle\\UserBundle\\Form\\Type\\AclRoleType/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Handler\\UserHandler/Pim\\Bundle\\UserBundle\\Form\\Handler\\UserHandler/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Handler\\ResetHandler/Pim\\Bundle\\UserBundle\\Form\\Handler\\ResetHandler/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Handler\\AclRoleHandler/Pim\\Bundle\\UserBundle\\Form\\Handler\\AclRoleHandler/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Security\\UserProvider/Pim\\Bundle\\UserBundle\\Security\\UserProvider/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Type\\ResetType/Pim\\Bundle\\UserBundle\\Form\\Type\\ResetType/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Type\\GroupType/Pim\\Bundle\\UserBundle\\Form\\Type\\GroupType/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Type\\GroupApiType/Pim\\Bundle\\UserBundle\\Form\\Type\\GroupApiType/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Type\\ChangePasswordType/Pim\\Bundle\\UserBundle\\Form\\Type\\ChangePasswordType/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Handler\\GroupHandler/Pim\\Bundle\\UserBundle\\Form\\Handler\\GroupHandler/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\Handler\\AbstractUserHandler/Pim\\Bundle\\UserBundle\\Form\\Handler\\AbstractUserHandler/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Entity\\EventListener\\UploadedImageSubscriber/Pim\\Bundle\\UserBundle\\EventSubscriber\\UploadedImageSubscriber/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Entity\\EntityUploadedImageInterface/Pim\\Component\\User\\EntityUploadedImageInterface/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Entity\\Repository/Pim\\Bundle\\UserBundle\\Doctrine\\ORM\\Repository/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Form\\EventListener/Pim\\Bundle\\UserBundle\\Form\\Subscriber/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\EventListener/Pim\\Bundle\\UserBundle\\EventListener/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Controller/Pim\\Bundle\\UserBundle\\Controller/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Pim\\Bundle\\UserBundle\\Controller\\UserRestController/Pim\\Bundle\\UserBundle\\Controller\\Rest\\UserController/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Pim\\Bundle\\UserBundle\\Controller\\SecurityRestController/Pim\\Bundle\\UserBundle\\Controller\\Rest\\SecurityController/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Pim\\Bundle\\UserBundle\\Controller\\UserGroupRestController/Pim\\Bundle\\UserBundle\\Controller\\Rest\\UserGroupController/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\OroUserEvents/Pim\\Component\\User\\UserEvents/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Entity\\UserManager/Pim\\Bundle\\UserBundle\\Manager\\UserManager/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Entity\\Role/Pim\\Component\\User\\Model\\Role/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Oro\\Bundle\\UserBundle\\Entity\\Group/Pim\\Component\\User\\Model\\Group/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Pim\\Bundle\\UserBundle\\Entity\\User/Pim\\Component\\User\\Model\\User/g'
find ./src/ -type f -print0 | xargs -0 sed -i 's/Pim\\Bundle\\UserBundle\\Entity\\UserInterface/Pim\\Component\\User\\Model\\UserInterface/g'