#include "ggwave/ggwave.h"

#include "ggwave-common.h"
#include "ggwave-common-sdl2.h"

#include <SDL.h>

#include <cstdio>
#include <string>

#include <mutex>
#include <thread>
#include <iostream>

int main(int argc, char** argv) {


    auto argm = parseCmdArguments(argc, argv);
        printf("Acoustic Authentication System\n");
    printf("Transmitter Side\n");
    int captureId = argm["c"].empty() ? 0 : std::stoi(argm["c"]);
    int playbackId = argm["p"].empty() ? 0 : std::stoi(argm["p"]);
    int txProtocolId = argm["t"].empty() ? 1 : std::stoi(argm["t"]);
    int payloadLength = argm["l"].empty() ? -1 : std::stoi(argm["l"]);
    bool printTones = argm.find("v") == argm.end() ? false : true;

    if (GGWave_init(playbackId, captureId, payloadLength) == false) {
        fprintf(stderr, "Failed to initialize GGWave\n");
        return -1;
    }

    auto ggWave = GGWave_instance();


    std::mutex mutex;
    std::thread inputThread([&]() {
        std::string inputOld = "";
        while (true) {
            std::string input;
            printf("Enter secure code to transmit: ");
            fflush(stdout);
            getline(std::cin, input);
            if (input.empty()) {
                printf("Re-sending ...\n");
                input = inputOld;


            } else {
                printf("Transmitting ...\n");
            }
            {
                std::lock_guard<std::mutex> lock(mutex);
                ggWave->init(input.size(), input.data(), ggWave->getTxProtocol(txProtocolId), 10);
            }
            inputOld = input;
        }
    });

    while (true) {
        std::this_thread::sleep_for(std::chrono::milliseconds(1));
        {
            std::lock_guard<std::mutex> lock(mutex);
            GGWave_mainLoop();
        }
    }

    inputThread.join();

    GGWave_deinit();

    SDL_CloseAudio();
    SDL_Quit();

    return 0;
}
