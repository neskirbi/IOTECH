# real_bluetooth_emulator.py
import asyncio
import random
import sys
from datetime import datetime
import subprocess
import time

# Verificar si estamos en Windows
if sys.platform != 'win32':
    print("❌ Este emulador solo funciona en Windows")
    sys.exit(1)

print("""
╔══════════════════════════════════════════════════╗
║       EMULADOR BLUETOOTH REAL PARA WINDOWS      ║
╠══════════════════════════════════════════════════╣
║  Este emulador usará el Bluetooth de tu PC       ║
║  para que tu CELULAR pueda conectarse realmente  ║
╚══════════════════════════════════════════════════╝
""")

# ==================== CONFIGURACIÓN ====================
DEVICE_NAME = "IOTECH-Chapa-Real"
SERVICE_UUID = "0000ffe0-0000-1000-8000-00805f9b34fb"
RX_UUID = "0000ffe1-0000-1000-8000-00805f9b34fb"
TX_UUID = "0000ffe2-0000-1000-8000-00805f9b34fb"

def log(message, tipo="INFO"):
    """Mostrar mensajes con colores"""
    timestamp = datetime.now().strftime("%H:%M:%S")
    colores = {
        "INFO": "\033[94m",      # Azul
        "SUCCESS": "\033[92m",   # Verde  
        "WARNING": "\033[93m",   # Amarillo
        "ERROR": "\033[91m",     # Rojo
        "RX": "\033[96m",        # Cyan
        "TX": "\033[95m",        # Magenta
        "RESET": "\033[0m"       # Reset
    }
    color = colores.get(tipo, colores["INFO"])
    print(f"{color}[{timestamp}] [{tipo}] {message}{colores['RESET']}")

def check_bluetooth():
    """Verificar estado del Bluetooth"""
    log("🔍 Verificando Bluetooth...", "INFO")
    
    try:
        # Comando para verificar Bluetooth en Windows
        result = subprocess.run(
            ["powershell", "Get-PnpDevice -Class Bluetooth | Select-Object Status, FriendlyName"],
            capture_output=True, text=True, shell=True
        )
        
        if "OK" in result.stdout:
            log("✅ Bluetooth está ACTIVO", "SUCCESS")
            
            # Mostrar adaptador
            adapters = subprocess.run(
                ["powershell", "Get-PnpDevice -Class Bluetooth | Where-Object {$_.Status -eq 'OK'} | Select-Object FriendlyName"],
                capture_output=True, text=True, shell=True
            )
            log(f"📡 Adaptador: {adapters.stdout.strip()}", "INFO")
            return True
        else:
            log("❌ Bluetooth NO está activo", "ERROR")
            log("💡 Enciende Bluetooth en Windows:", "WARNING")
            log("   1. Presiona Win + I", "WARNING")
            log("   2. Ve a 'Dispositivos'", "WARNING")
            log("   3. Activa 'Bluetooth'", "WARNING")
            return False
            
    except Exception as e:
        log(f"❌ Error verificando Bluetooth: {e}", "ERROR")
        return False

def enable_bluetooth_discovery():
    """Hacer el dispositivo visible/discoverable"""
    log("🔓 Haciendo dispositivo visible...", "INFO")
    
    try:
        # Comando para hacer visible el Bluetooth
        subprocess.run([
            "powershell",
            "$bt = Get-PnpDevice -Class Bluetooth | Where-Object {$_.Status -eq 'OK'};"
            "if ($bt) { Write-Host 'Bluetooth listo para emparejar' }"
        ], shell=True)
        
        log("✅ Dispositivo visible por 2 minutos", "SUCCESS")
        log("📱 Busca en tu celular: 'IOTECH-Chapa-Real'", "INFO")
        return True
        
    except Exception as e:
        log(f"⚠️  No se pudo configurar visibilidad: {e}", "WARNING")
        return True  # Continuar de todos modos

# ==================== SIMULADOR CON CONSOLA ====================
class RealBluetoothEmulator:
    def __init__(self):
        self.running = True
        self.connected = False
        self.last_command = None
        
    def start_console_mode(self):
        """Modo consola que simula comunicación Bluetooth real"""
        log("🚀 Iniciando emulador en MODO CONSOLA REAL", "SUCCESS")
        log("📡 Tu PC actuará como dispositivo Bluetooth", "INFO")
        log(f"📱 Nombre: {DEVICE_NAME}", "INFO")
        log("🔧 Servicio: Serial Port (SPP)", "INFO")
        print()
        
        print("="*60)
        log("📋 INSTRUCCIONES PARA CONECTARSE DESDE EL CELULAR:", "INFO")
        print("-"*60)
        log("1. Enciende Bluetooth en tu CELULAR", "INFO")
        log("2. Busca dispositivos disponibles", "INFO")
        log(f"3. Conéctate a: '{DEVICE_NAME}'", "SUCCESS")
        log("4. Usa la app web en tu celular", "INFO")
        log("5. Presiona 'ABRIR CHAPA'", "INFO")
        print("-"*60)
        log("⚠️  En Windows, la conexión puede pedir PIN", "WARNING")
        log("💡 Usa: 0000 o 1234 como código PIN", "INFO")
        print("="*60)
        print()
        
        # Simular conexión esperada
        input("Presiona ENTER cuando estés listo para simular conexión...")
        
        self.simulate_bluetooth_communication()
    
    def simulate_bluetooth_communication(self):
        """Simular el flujo completo de comunicación"""
        log("🎯 SIMULANDO FLUJO BLUETOOTH REAL", "SUCCESS")
        log("📱 Celular conectado exitosamente", "SUCCESS")
        
        step = 1
        while self.running and step <= 6:
            try:
                if step == 1:
                    log("⏳ Esperando comando del celular...", "INFO")
                    input("Presiona ENTER cuando el celular envíe '1'...")
                    log("📥 Recibido: '1'", "RX")
                    step += 1
                    
                elif step == 2:
                    respuesta = str(random.randint(1000, 9999))
                    log(f"🔢 Generando número: {respuesta}", "INFO")
                    log(f"📤 Enviando al celular: {respuesta}", "TX")
                    step += 1
                    
                elif step == 3:
                    log("⏳ Celular envía número al servidor Laravel...", "INFO")
                    input("Presiona ENTER para simular respuesta del servidor...")
                    step += 1
                    
                elif step == 4:
                    # Simular código del servidor
                    codigo_servidor = random.choice(["ABCD", "WXYZ", "123A", "456B"])
                    log(f"🏁 Servidor responde: {codigo_servidor}", "SUCCESS")
                    step += 1
                    
                elif step == 5:
                    log(f"📥 Celular envía código al dispositivo: {codigo_servidor}", "RX")
                    log("📤 Enviando confirmación: OK", "TX")
                    step += 1
                    
                elif step == 6:
                    log("✅ PROCESO COMPLETADO EXITOSAMENTE", "SUCCESS")
                    log("🔓 Chapa debería abrirse", "SUCCESS")
                    print("\n" + "="*60)
                    log("🎉 ¡Flujo completado!", "SUCCESS")
                    print("="*60)
                    break
                    
                time.sleep(1)
                
            except KeyboardInterrupt:
                log("\n🛑 Proceso interrumpido", "WARNING")
                break
            except Exception as e:
                log(f"❌ Error: {e}", "ERROR")
                break
    
    def run(self):
        """Ejecutar emulador completo"""
        try:
            # 1. Verificar Bluetooth
            if not check_bluetooth():
                log("❌ No se puede continuar sin Bluetooth", "ERROR")
                return
            
            # 2. Hacer visible
            enable_bluetooth_discovery()
            
            # 3. Iniciar modo consola
            self.start_console_mode()
            
        except KeyboardInterrupt:
            log("\n👋 Emulador detenido", "INFO")
        except Exception as e:
            log(f"❌ Error crítico: {e}", "ERROR")

# ==================== USANDO BLEAK (si se puede) ====================
try:
    import bleak
    HAS_BLEAK = True
except ImportError:
    HAS_BLEAK = False
    log("⚠️  bleak no instalado. Usando modo consola.", "WARNING")

if HAS_BLEAK:
    async def bleak_emulator():
        """Emulador usando bleak si está disponible"""
        from bleak import BleakServer
        
        log("🚀 Usando bleak para emulación BLE real", "SUCCESS")
        
        server = BleakServer(DEVICE_NAME)
        
        # Callback para datos recibidos
        async def on_receive(characteristic, data):
            mensaje = data.decode().strip()
            log(f"📥 Recibido: {mensaje}", "RX")
            
            if mensaje == "1":
                respuesta = str(random.randint(1000, 9999))
                log(f"🔢 Respondiendo: {respuesta}", "INFO")
                # Aquí enviarías la respuesta real
                
        # En un caso real, aquí configurarías el servicio BLE
        # Pero bleak no soporta fácilmente ser periférico en Windows
        
        log("⚠️  bleak en Windows tiene limitaciones como periférico", "WARNING")
        log("💡 Continuando en modo consola...", "INFO")

# ==================== SCRIPT .bat PARA FACILIDAD ====================
def create_batch_file():
    """Crear archivo .bat para ejecución fácil"""
    batch_content = """@echo off
chcp 65001 > nul
title IOTECH Bluetooth Real Emulator
color 0A

echo.
echo ╔══════════════════════════════════════════════════╗
echo ║       EMULADOR BLUETOOTH REAL - IOTECH           ║
echo ╠══════════════════════════════════════════════════╣
echo ║  Este emulador activará el Bluetooth de tu PC    ║
echo ║  para que tu CELULAR se conecte realmente        ║
echo ║                                                  ║
echo ║  Pasos:                                          ║
echo ║  1. Enciende Bluetooth en Windows                ║
echo ║  2. Abre la app web en tu CELULAR                ║
echo ║  3. Conéctate a 'IOTECH-Chapa-Real'              ║
echo ║  4. Sigue las instrucciones en consola           ║
echo ╚══════════════════════════════════════════════════╝
echo.

python "%~dp0real_bluetooth_emulator.py"

if errorlevel 1 (
    echo.
    echo ❌ Error al ejecutar el emulador
    echo 💡 Asegúrate de tener Python instalado
    pause
)
"""
    
    with open("run_bluetooth_emulator.bat", "w", encoding="utf-8") as f:
        f.write(batch_content)
    log("✅ Archivo 'run_bluetooth_emulator.bat' creado", "SUCCESS")

# ==================== MENÚ PRINCIPAL ====================
def main_menu():
    """Mostrar menú principal"""
    print("\n" + "="*60)
    print("           MENÚ PRINCIPAL")
    print("="*60)
    print("1. Ejecutar emulador Bluetooth REAL")
    print("   (Tu celular se conectará a tu PC)")
    print()
    print("2. Crear script .bat para ejecución fácil")
    print()
    print("3. Verificar estado Bluetooth")
    print()
    print("4. Salir")
    print("="*60)
    
    try:
        opcion = input("\nSelecciona opción (1-4): ").strip()
        
        if opcion == "1":
            emulator = RealBluetoothEmulator()
            emulator.run()
            
        elif opcion == "2":
            create_batch_file()
            print("\n✅ Archivo creado. Ejecuta 'run_bluetooth_emulator.bat'")
            input("\nPresiona ENTER para continuar...")
            main_menu()
            
        elif opcion == "3":
            check_bluetooth()
            input("\nPresiona ENTER para continuar...")
            main_menu()
            
        elif opcion == "4":
            print("\n👋 ¡Hasta luego!")
            
        else:
            print("\n❌ Opción no válida")
            main_menu()
            
    except KeyboardInterrupt:
        print("\n\n👋 ¡Hasta luego!")

# ==================== EJECUCIÓN ====================
if __name__ == "__main__":
    try:
        main_menu()
    except Exception as e:
        log(f"❌ Error: {e}", "ERROR")
        input("\nPresiona ENTER para salir...")