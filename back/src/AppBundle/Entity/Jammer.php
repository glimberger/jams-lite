<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use AppBundle\Utils\Roles;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class Jammer
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="jammer")
 * @ORM\Entity()
 *
 * @ApiResource()
 */
class Jammer implements AdvancedUserInterface
{
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="email", options={"comment": "email address"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="alias", options={"comment": "alias name"})
     */
    private $alias;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", name="password", options={"comment": "password"})
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="enabled", options={"comment": "user is enabled or not"})
     */
    private $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="locked", options={"comment": "account is locked or not"})
     */
    private $accountLocked;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="expired", options={"comment": "account is expired or not"})
     */
    private $accountExpired;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="JamSession", mappedBy="owner")
     */
    private $sessions;

    /**
     * Jammer constructor.
     *
     * @param UuidInterface|null $id
     * @param string             $email
     * @param string             $alias
     */
    public function __construct(?UuidInterface $id, string $email, string $alias)
    {
        $this->id = $id;
        $this->setSalt($this->generateSalt());
        $this->setAccountLocked(false);
        $this->setAccountExpired(false);
        $this->disable();
        $this->setRoles([Roles::USER]);
        $this->setUsername($email);
        $this->setAlias($alias);
        $this->resetSessionCollection();
    }

    /**
     * @return null|UuidInterface
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param null|string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string $role
     *
     * @return $this
     */
    public function addRole(string $role)
    {
        if (!in_array($role, Roles::ALL, true)) {
            throw new \InvalidArgumentException(sprintf("%s is not a valid role", $role));
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param string[] $roles
     *
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword(string $plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     *
     * @return $this
     */
    public function setSalt(?string $salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Generates a new salt.
     * http://stackoverflow.com/questions/2235434/how-to-generate-a-random-long-salt-for-use-in-hashing#answer-2235573
     *
     * @return string
     */
    private function generateSalt(): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows
            return uniqid(mt_rand(), true);
        }
        else {
            // Linux, OS X
            return bin2hex(file_get_contents('/dev/urandom', false, null, 0, 32));
        }
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setUsername(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;

        return $this;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired(): bool
    {
        return !$this->accountExpired;
    }

    /**
     * @param bool $accountExpired
     *
     * @return $this
     */
    public function setAccountExpired(bool $accountExpired)
    {
        $this->accountExpired = $accountExpired;

        return $this;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked(): bool
    {
        return !$this->accountLocked;
    }

    /**
     * @param bool $accountLocked
     *
     * @return $this
     */
    private function setAccountLocked(bool $accountLocked)
    {
        $this->accountLocked = $accountLocked;

        return $this;
    }

    /**
     * @return $this
     */
    public function lockAccount()
    {
        $this->setAccountLocked(true);

        return $this;
    }

    /**
     * @return $this
     */
    public function unlockAccount()
    {
        $this->setAccountLocked(false);

        return $this;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired(): bool
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    private function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return $this
     */
    public function enable()
    {
        $this->setEnabled(true);

        return $this;
    }

    /**
     * @return $this
     */
    public function disable()
    {
        $this->setEnabled(false);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    /**
     * @param JamSession[] $sessions
     * @return Jammer
     */
    public function setSessions(array $sessions): Jammer
    {
        $this->sessions = new ArrayCollection($sessions);

        return $this;
    }

    /**
     * @return Jammer
     */
    public function resetSessionCollection(): Jammer
    {
        return $this->setSessions([]);
    }

    /**
     * @param JamSession $session
     * @return Jammer
     */
    public function addSession(JamSession $session): Jammer
    {
        if (!$this->getSessions()->contains($session)) {
            $this->getSessions()->add($session);
        }

        return $this;
    }

    /**
     * @param JamSession $session
     * @return Jammer
     */
    public function removeSession(JamSession $session): Jammer
    {
        if ($this->getSessions()->contains($session)) {
            $this->getSessions()->removeElement($session);
        }

        return $this;
    }
}