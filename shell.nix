let
  nixpkgs = fetchTarball "https://github.com/NixOS/nixpkgs/archive/eb28b94bd14835836b539bc3854a6abf929876d4.tar.gz";
  pkgs = import nixpkgs { config = {}; overlays = []; };
in

let
  pnpm = pkgs.callPackage ./tools/nix/pnpm.nix { nodejs = pkgs.nodejs_20; };
in

pkgs.mkShellNoCC {
  name = "piclib-dev-env";

  packages = [
    pkgs.git
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.nodejs_20
    pnpm
  ];
}